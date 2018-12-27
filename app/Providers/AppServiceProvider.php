<?php

namespace App\Providers;

use App\Enums\UserType;
use CollabCorp\LaravelFeatureToggle\Feature;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::if('admin', function () {
            return Auth::check()
                && Auth::user()->type === UserType::Admin;
        });

        Feature::bind('env', function ($user, array $environments) {
            return app()->environment($environments);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
