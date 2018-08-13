<?php

namespace App\Http\Controllers;

use App\Services\AdminService;

/**
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * @var AdminService
     */
    protected $adminService;

    /**
     * AdminController constructor.
     * @param AdminService $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->middleware('auth');
        $this->adminService = $adminService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin', ['urls' => $this->adminService->getAllUrls()]);
    }
}
