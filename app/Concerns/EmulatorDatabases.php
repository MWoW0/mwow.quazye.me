<?php

namespace App\Concerns;

use App\Contracts\Emulator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait EmulatorDatabases
{
    public static function bootEmulatorDatabases()
    {
        static::setConnectionResolver(
            resolve(Emulator::class)->database()->connectionResolver()
        );
    }

    /**
     * Make a new model instance connected to given emulator
     *
     * @param Emulator $emulator
     * @param array $attributes
     * @return EmulatorDatabases|Builder|Model
     */
    public static function makeWithEmulator(Emulator $emulator, array $attributes = [])
    {
        static::setConnectionResolver($emulator->database()->connectionResolver());

        return new static($attributes);
    }

    /**
     * Create a new instance of the model
     *
     * @param Emulator $emulator
     * @param array $attributes
     * @return Model
     */
    public static function createWithEmulator(Emulator $emulator, array $attributes = [])
    {
        return tap(static::makeWithEmulator($emulator, $attributes), function ($model) {
            $model->saveOrFail();
        });
    }
}
