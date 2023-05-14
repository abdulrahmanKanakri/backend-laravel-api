<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        return ApiResponse::success(['categories' => $categories]);
    }
}
