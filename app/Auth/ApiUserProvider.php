<?php

namespace App\Auth;

use GuzzleHttp\Client;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Session\Session;

/**
 * Class ApiUserProvider
 * @package App\Auth
 */
class ApiUserProvider implements UserProvider
{
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var Session
     */
    protected $session;

    /**
     * ApiUserProvider constructor.
     * @param Client $httpClient
     * @param Session $session
     */
    public function __construct(Client $httpClient, Session $session)
    {
        $this->httpClient = $httpClient;
        $this->session = $session;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $response = $this->httpClient->request('POST', 'auth/login', [
            'http_errors' => false,
            'json' => [
                'username' => $credentials['username'],
                'password' => $credentials['password']
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            return;
        }

        $responseBody = json_decode($response->getBody());

        $user = [
            'username' => $credentials['username'],
            'password' => $credentials['password'],
            'token_type' => $responseBody->token_type,
            'access_token' => $responseBody->access_token
        ];

        return $this->getApiUser($user);
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        if ($identifier !== $this->session->get('user.username')
            || !$this->session->has('user.token_type')
            || !$this->session->has('user.access_token')) {
            return null;
        }

        $user = [
            'username' => $identifier,
            'token_type' => $this->session->get('user.token_type'),
            'access_token' => $this->session->get('user.access_token')
        ];

        return $this->getApiUser($user);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        return $user->getAuthPassword() == $credentials['password'];
    }

    /**
     * Get the api user.
     *
     * @param  mixed  $user
     * @return \App\Auth\ApiUser|null
     */
    protected function getApiUser(array $user)
    {
        return new ApiUser($user);
    }

    public function retrieveByToken($identifier, $token) { }
    public function updateRememberToken(UserContract $user, $token) { }
}
