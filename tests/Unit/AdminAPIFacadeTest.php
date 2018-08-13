<?php

namespace Tests\Unit;

use App\Facades\AdminAPIFacade;
use GuzzleHttp\Client;
use Illuminate\Session\Store;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class AdminAPIFacadeTest extends TestCase
{
    protected $httpClient;

    protected $session;

    protected $adminFacade;

    protected function setUp()
    {
        parent::setUp();
        $this->httpClient = $this->createMock(Client::class);
        $this->session = $this->createMock(Store::class);
        $this->adminFacade = new AdminAPIFacade($this->httpClient, $this->session);
    }

    public function testGetURLsTokenExpired()
    {
        $access_token = 'user_access_token';
        $this->session->expects($this->once())
            ->method('get')
            ->with('user.access_token')
            ->willReturn($access_token);

        $message = $this->createMock(ResponseInterface::class);
        $message->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(401);
        $message->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode(['error' => 'Unauthenticated']));

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                'admin/urls',
                [
                    'http_errors' => false,
                    'headers' => [
                        'Authorization' => 'bearer ' . $access_token
                    ]
                ]
            )
            ->willReturn($message);

        $this->session->expects($this->once())
            ->method('invalidate');

        $this->adminFacade->getUrls();
    }

    public function testGetURLs()
    {
        $access_token = 'user_access_token';
        $this->session->expects($this->once())
            ->method('get')
            ->with('user.access_token')
            ->willReturn($access_token);

        $message = $this->createMock(ResponseInterface::class);
        $message->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(200);
        $message->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode([['id' => 99]]));

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with(
                'GET',
                'admin/urls',
                [
                    'http_errors' => false,
                    'headers' => [
                        'Authorization' => 'bearer ' . $access_token
                    ]
                ]
            )
            ->willReturn($message);

        $this->adminFacade->getUrls();
    }
}
