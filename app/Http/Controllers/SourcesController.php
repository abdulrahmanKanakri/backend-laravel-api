<?php

namespace App\Http\Controllers;

use App\Models\Source;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;

class SourcesController extends Controller
{
    public function index(Request $request)
    {
        $sources = Source::all();
        return ApiResponse::success(['sources' => $sources]);
    }
}
