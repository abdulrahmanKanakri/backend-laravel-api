<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::all();
        return ApiResponse::success(['authors' => $authors]);
    }
}
