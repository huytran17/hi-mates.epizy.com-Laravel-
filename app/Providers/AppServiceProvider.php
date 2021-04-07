<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cookie;
use App\Models\TeamUser;
use App\Models\Team;
use App\Observers\TeamUserObserver;
use App\Observers\TeamObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TeamUser::observe(TeamUserObserver::class);
        Team::observe(TeamObserver::class);
    }
}
