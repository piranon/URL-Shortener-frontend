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

    /**
     * @return array|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function getUrls()
    {
        $response = $this->httpClient->request('GET', 'admin/urls',[
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'bearer ' . $this->session->get('user.access_token')
            ]
        ]);

        $responseBody = json_decode($response->getBody());

        if ((int)$response->getStatusCode() === 401) {
            Auth::guard()->logout();
            $this->session->invalidate();
            return redirect('/');
        }

        if ((int)$response->getStatusCode() !== 200) {
            $responseBody = [];
        }

        return $responseBody;
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteUrl($id)
    {
        $response = $this->httpClient->request('DELETE', 'admin/urls/' . $id,[
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'bearer ' . $this->session->get('user.access_token')
            ]
        ]);

        if ((int)$response->getStatusCode() === 401) {
            Auth::guard()->logout();
            $this->session->invalidate();
            return redirect('/');
        }

        if ((int)$response->getStatusCode() !== 202) {
            $responseBody = json_decode($response->getBody());

            return ['success' => false, 'message' => $responseBody->message];
        }

        return ['success' => true, 'message' => 'URL deleted'];
    }
}
