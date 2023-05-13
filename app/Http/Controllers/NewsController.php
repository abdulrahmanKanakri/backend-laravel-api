<?php

namespace App\Http\Controllers;

use App\Services\News\INewsService;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(private INewsService $newsService)
    {
    }

    public function index(Request $request)
    {
        // validate page => positive int
        $keyword = $request->keyword ?? '';
        $page = $request->page ?? 0;

        $news = $this->newsService->fetchNewsList($keyword, $page);

        return ApiResponse::success($news, 'Successfully retrieved');
    }
}
