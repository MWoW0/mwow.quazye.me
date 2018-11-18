<?php

namespace App\Concerns;

use App\Contracts\Emulator;

trait EmulatorDatabases
{
    public static function bootEmulatorDatabases()
    {
        static::setConnectionResolver(
            resolve(Emulator::class)->database()->connectionResolver()
        );
    }

    public static function makeWithEmulator(Emulator $emulator, array $attributes = [])
    {
        static::setConnectionResolver($emulator->database()->connectionResolver());

        return new static($attributes);
    }

    public static function createWithEmulator(Emulator $emulator, array $attributes = [])
    {
        return tap(static::makeWithEmulator($emulator, $attributes), function ($model) {
            $model->saveOrFail();
        });
    }
}
