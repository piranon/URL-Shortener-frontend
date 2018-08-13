<?php

namespace App\Facades;

use GuzzleHttp\Client;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

/**
 * Class AdminFacades
 * @package App\Facades
 */
class AdminAPIFacade implements AdminFacadeInterface
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
     * AdminFacades constructor.
     * @param Client $httpClient
     * @param Session $session
     */
    public function __construct(Client $httpClient, Session $session)
    {
        $this->httpClient = $httpClient;
        $this->session = $session;
    }

    public function getUrls()
    {
        $response = $this->httpClient->request('GET', 'admin/urls',[
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'bearer ' . $this->session->get('user.access_token')
            ]
        ]);

        $responseBody = json_decode($response->getBody());

        if ($response->getStatusCode() === 401) {
            Auth::guard()->logout();
            $this->session->invalidate();
            return redirect('/');
        }

        if ($response->getStatusCode() !== 200) {
            $responseBody = [];
        }

        return $responseBody;
    }
}
