<?php

namespace App\Providers;

use App\Services\News\AggregatedSources;
use App\Services\News\INewsSource;
use App\Services\News\BBCNewsSource;
use App\Services\News\CBCNewsSource;
use App\Services\News\NewYorkTimesSource;
use App\Services\News\TheGuardianSource;
use App\Services\User\CurrentUserService;
use App\Services\User\ICurrentUserService;
use App\Services\User\IUserService;
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
        INewsSource::class => AggregatedSources::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AggregatedSources::class, function () {
            return new AggregatedSources(
                new NewYorkTimesSource(
                    env("NEW_YORK_TIMES_ENDPOINT"),
                    env("NEW_YORK_TIMES_API_KEY")
                ),
                new TheGuardianSource(
                    env("THE_GUARDIAN_ENDPOINT"),
                    env("THE_GUARDIAN_API_KEY")
                ),
                new BBCNewsSource(
                    env("NEWSAPI_ENDPOINT"),
                    env("NEWSAPI_API_KEY")
                ),
                new CBCNewsSource(
                    env("NEWSAPI_ENDPOINT"),
                    env("NEWSAPI_API_KEY")
                )
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
