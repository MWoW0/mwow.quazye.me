<?php

namespace App\Concerns;

use App\Contracts\Emulator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use function tap;

trait connectsToEmulator
{
    public static function bootEmulatorDatabases()
    {
        // resolve(Emulator::class)->connectModel(new self);
    }

    /**
     * Make a new model instance connected to given emulator
     *
     * @param Emulator $emulator
     * @return connectsToEmulator|Builder|Model
     */
    public static function connectedTo(Emulator $emulator)
    {
        return tap(new static, function (Model $model) use ($emulator) {
            $emulator->connectModel($model);
        });
    }
}
