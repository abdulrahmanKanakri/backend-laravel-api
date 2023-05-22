<?php

namespace App\Http\Controllers;

use App\Http\Requests\News\GetNewsListRequest;
use App\Services\News\INewsService;
use App\Utils\ApiResponse;

class NewsController extends Controller
{
    public function __construct(private INewsService $newsService)
    {
    }

    public function index(GetNewsListRequest $request)
    {
        $news = $this->newsService->fetchNewsList($request->all());

        return ApiResponse::success($news, 'Successfully retrieved');
    }
}
