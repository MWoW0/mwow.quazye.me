<?php

namespace App\Collections;

use App\Emulator;
use Illuminate\Support\Collection;
use function is_object;

class EmulatorCollection extends Collection
{
    public function mapToInstances(): EmulatorCollection
    {
        return $this->map(function ($emulator) {
            if (is_object($emulator)) {
                return [$emulator];
            }

            return Emulator::make($emulator);
        })->values();
    }
}
