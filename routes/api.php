<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [RegisterController::class, 'register']);

Route::post('login', [LoginController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Auth
    Route::get('/me', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [LogoutController::class, 'logout']);

    // News
    Route::get('news', [NewsController::class, 'index']);
});
