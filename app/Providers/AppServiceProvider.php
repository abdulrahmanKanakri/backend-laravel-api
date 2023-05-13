<?php

namespace App\Providers;

use App\Services\News\INewsService;
use App\Services\News\NewsService;
use App\Services\User\CurrentUserService;
use App\Services\User\ICurrentUserService;
use App\Services\User\IUserPreferencesService;
use App\Services\User\IUserService;
use App\Services\User\UserPreferencesService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        IUserService::class => UserService::class,
        ICurrentUserService::class => CurrentUserService::class,
        IUserPreferencesService::class => UserPreferencesService::class,
        INewsService::class => NewsService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
