<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');

        $result = $this->adminService->deleteUrl($id);

        return redirect('admin')->with($result);
    }

    public function search(Request $request)
    {
        $field = $request->input('field');
        $searchText = $request->input('search_text');

        return view('admin', ['urls' => $this->adminService->search($field, $searchText)]);
    }
}
