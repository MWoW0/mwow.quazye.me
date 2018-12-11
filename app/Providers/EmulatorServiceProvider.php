<?php

namespace App\Providers;

use App\Console\Commands\MakeEmulatorCommand;
use App\Emulator;
use Illuminate\Support\ServiceProvider;
use function app_path;

class EmulatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Emulator::discover(app_path('Emulators'));
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            MakeEmulatorCommand::class
        ]);
    }
}
