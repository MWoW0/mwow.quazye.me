<?php

namespace App\Providers;

use App\Contracts\Emulator;
use App\Contracts\Emulators\GathersGameStatistics;
use App\Contracts\Emulators\ResolvesDatabaseConnections;
use App\Contracts\Emulators\SendsIngameMails;
use App\Emulators\EmulatorManager;
use App\Enums\UserType;
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEmulatorBindings();
    }

    public function registerEmulatorBindings()
    {
        $this->app->singleton(EmulatorManager::class, function ($app) {
            return new EmulatorManager($app);
        });

        $this->app->bind(Emulator::class, function ($app) {
            return $app[EmulatorManager::class]->driver();
        });

        $this->app->bind(SendsIngameMails::class, function ($app) {
            return Mail::makeWithEmulator($app[Emulator::class]);
        });

        $this->app->bind(ResolvesDatabaseConnections::class, function ($app) {
            return $app[Emulator::class]->database();
        });

        $this->app->bind(GathersGameStatistics::class, function ($app) {
            return $app[Emulator::class]->statistics();
        });
    }
}
