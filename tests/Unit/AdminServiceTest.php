<?php

namespace Tests\Unit;

use App\Facades\AdminFacadeInterface;
use App\Models\URLView;
use App\Services\AdminService;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    protected $adminFacade;

    protected $adminService;

    protected function setUp()
    {
        parent::setUp();
        $this->adminFacade = $this->createMock(AdminFacadeInterface::class);
        $this->adminService = new AdminService($this->adminFacade);
    }

    public function testGetAllUrls()
    {
        $responseMock = new \stdClass();
        $responseMock->id = 10;
        $responseMock->code = 'zyx';
        $responseMock->hits = 99;
        $responseMock->url = 'https://www.thailandhoro.com/';
        $responseMock->status = 'active';
        $responseMock->expires_in = '2018-09-09 00:24:55';
        $responseMock->created_at = '2018-08-12 16:48:28';
        $responseMock->updated_at = '2018-08-12 16:48:28';

        $this->adminFacade->expects($this->once())
            ->method('getUrls')
            ->with()
            ->willReturn([$responseMock]);

        $urls = $this->adminService->getAllUrls();
        $url = $urls[0];

        $this->assertInstanceOf(URLView::class, $url);
        $this->assertEquals($responseMock->id, $url->id);
        $this->assertEquals($responseMock->code, $url->code);
        $this->assertEquals($responseMock->hits, $url->hits);
        $this->assertEquals($responseMock->url, $url->url);
        $this->assertEquals($responseMock->status, $url->status);
        $this->assertEquals($responseMock->expires_in, $url->expires);
        $this->assertEquals($responseMock->created_at, $url->created);
        $this->assertEquals($responseMock->updated_at, $url->updated);
    }

    public function testDeleteIdWithEmptyID()
    {
        $result = $this->adminService->deleteUrl('');
        $this->assertEquals(
            ['success' => false, 'message' => 'Invalid URL ID.'],
            $result
        );
    }

    public function testDeleteIdSuccess()
    {
        $id = 99;
        $expected = ['success' => true, 'message' => 'URL deleted'];

        $this->adminFacade->expects($this->once())
            ->method('deleteUrl')
            ->with($id)
            ->willReturn($expected);

        $result = $this->adminService->deleteUrl($id);
        $this->assertEquals($expected, $result);
    }
}
