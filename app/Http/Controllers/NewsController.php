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
        $keyword = $request->keyword ?? '';

        $news = $this->newsSource->fetchNewsList($keyword);

        return ApiResponse::success($news, 'Successfully retrieved');
    }
}
