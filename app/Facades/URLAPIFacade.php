<?php

namespace App\Facades;

use GuzzleHttp\Client;

/**
 * Class URLAPIFacade
 * @package App\Facades
 */
class URLAPIFacade implements URLFacadeInterface
{
    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * URLAPIFacade constructor.
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param array $url
     * @return mixed
     */
    public function createUrl(array $url)
    {
        $response = $this->httpClient->request('POST', 'urls', [
            'http_errors' => false,
            'json' => $url
        ]);

        $responseBody = json_decode($response->getBody(), true);

        if ((int)$response->getStatusCode() !== 201) {
            $responseBody['success'] = false;
        }

        return $responseBody;
    }
}
