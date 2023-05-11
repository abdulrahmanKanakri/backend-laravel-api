<?php

namespace App\Http\Controllers;

use App\Services\News\INewsSource;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct(private INewsSource $newsSource)
    {
    }

    public function index(Request $request)
    {
        // validate page => positive int
        $keyword = $request->keyword ?? '';
        $page = $request->page ?? 0;

        $news = $this->newsSource->fetchNewsList($keyword, $page);

        return ApiResponse::success($news, 'Successfully retrieved');
    }
}
