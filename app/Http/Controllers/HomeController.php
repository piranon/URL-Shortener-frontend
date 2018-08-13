<?php

namespace App\Http\Controllers;

use App\Services\URLService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var URLService
     */
    protected $urlService;

    /**
     * HomeController constructor.
     * @param URLService $urlService
     */
    public function __construct(URLService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $url = $request->input('url');
        $expires = $request->input('expires');

        $result = $this->urlService->create($url, $expires);

        return redirect('/')->with($result);
    }

    /**
     * @param Request $request
     * @param $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(Request $request, $code)
    {
        $url = $this->urlService->getRedirectUrl($code);

        switch ($url['http_code']) {
            case Response::HTTP_NOT_FOUND:
                return response(Response::$statusTexts[Response::HTTP_NOT_FOUND]);
            case Response::HTTP_GONE:
                return response(Response::$statusTexts[Response::HTTP_GONE]);
            default:
                return redirect()->away($url['url'], $url['http_code']);
        }
    }
}
