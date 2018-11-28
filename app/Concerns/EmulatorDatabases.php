<?php

namespace App\Concerns;

use App\Contracts\Emulator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use function tap;

trait EmulatorDatabases
{
    public static function bootEmulatorDatabases()
    {
        // resolve(Emulator::class)->database()->configureModel(new self);
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
        return tap(new static($attributes), function (Model $model) use ($emulator) {
            $emulator->database()->configureModel($model);
        });
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
        return tap(static::makeWithEmulator($emulator, $attributes), function (Model $model) use ($attributes) {
            $model->saveOrFail();
        });
    }

    /**
     * Create a new instance of the model
     *
     * @param Emulator $emulator
     * @param array $attributes
     * @return Model
     */
    public static function firstOrCreateWithEmulator(Emulator $emulator, array $attributes = [])
    {
        $emulator->database()->configureModel($model = new static);

        return $model->firstOrCreate($attributes);
    }
}
