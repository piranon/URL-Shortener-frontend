<?php

namespace Tests\Unit;

use App\Facades\URLFacadeInterface;
use App\Services\URLService;
use Tests\TestCase;

class URLServiceTest extends TestCase
{
    protected $urlFacade;

    protected $urlService;

    protected function setUp()
    {
        parent::setUp();
        $this->urlFacade = $this->createMock(URLFacadeInterface::class);
        $this->urlService = new URLService($this->urlFacade);
    }

    public function testCreateUrlNoExpires()
    {
        $url = 'https://www.siam4friend.com';
        $expires = 0;

        $create = [
            'url' => $url
        ];

        $this->urlFacade->expects($this->once())
            ->method('createUrl')
            ->with($create)
            ->willReturn(['success' => true]);

        $this->urlService->create($url, $expires);
    }


    public function testCreateUrlWithExpires()
    {
        $url = 'https://www.siam4friend.com';
        $expires = 7;

        $create = [
            'url' => $url
        ];

        $dateTime = new \DateTime();
        $dateTime->modify('+' . $expires . ' day');
        $create['expires'] = $dateTime->format('Y-m-d H:i:s');

        $this->urlFacade->expects($this->once())
            ->method('createUrl')
            ->with($create)
            ->willReturn(['success' => true]);

        $this->urlService->create($url, $expires);
    }
}
