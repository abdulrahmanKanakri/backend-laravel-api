<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\SourcesController;
use App\Http\Controllers\User\UserPreferencesController;
use App\Http\Controllers\User\UserSettingsController;
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
    Route::post('me', [UserController::class, 'me']);
    Route::post('logout', [LogoutController::class, 'logout']);

    // User profile
    Route::group(['prefix' => 'profile'], function () {

        // Preferences
        Route::put('preferred-sources', [UserPreferencesController::class, 'updatePreferredSources']);
        Route::put('preferred-categories', [UserPreferencesController::class, 'updatePreferredCategories']);
        Route::put('preferred-authors', [UserPreferencesController::class, 'updatePreferredAuthors']);

        // Settings
        Route::put('update-settings', [UserSettingsController::class, 'updateUserSettings']);
    });

    // Constants
    Route::get('sources', [SourcesController::class, 'index']);
    Route::get('categories', [CategoriesController::class, 'index']);
    Route::get('authors', [AuthorsController::class, 'index']);

    // News
    Route::get('news', [NewsController::class, 'index']);
});
