<?php

namespace Tests\Unit;

use App\Facades\URLAPIFacade;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

class URLAPIFacadeTest extends TestCase
{
    protected $httpClient;

    protected $urlFacade;

    protected function setUp()
    {
        parent::setUp();
        $this->httpClient = $this->createMock(Client::class);
        $this->urlFacade = new URLAPIFacade($this->httpClient);
    }

    public function testCreateUrlSuccess()
    {
        $url = ['url' => 'https//www.test'];

        $message = $this->createMock(ResponseInterface::class);
        $message->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(201);
        $message->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode(['success' => true]));

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'urls',
                [
                    'http_errors' => false,
                    'json' => $url
                ]
            )
            ->willReturn($message);

        $this->urlFacade->createUrl($url);
    }

    public function testCreateUrlFail()
    {
        $url = ['url' => 'test'];

        $message = $this->createMock(ResponseInterface::class);
        $message->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(400);
        $message->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode(['message' => 'URL not valid']));

        $this->httpClient->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                'urls',
                [
                    'http_errors' => false,
                    'json' => $url
                ]
            )
            ->willReturn($message);

        $result = $this->urlFacade->createUrl($url);

        $this->assertEquals(
            ['success' => false, 'message' => 'URL not valid'],
            $result
        );
    }
}
