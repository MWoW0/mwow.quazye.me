<?php

namespace App\Facades;

use App\Contracts\Emulator as EmulatorContract;
use App\Emulators\EmulatorManager;
use Illuminate\Support\Facades\Facade;

class Emulator extends Facade
{
    public static function driver($name = null): EmulatorContract
    {
        return static::getFacadeRoot()->driver($name);
    }

    /**
     * Get an array of supported emulator driver names or check if given is supported
     *
     * @param string $emulator
     * @throws \ReflectionException
     * @return array|bool
     */
    public static function isSupported(string $emulator): bool
    {
        return in_array($emulator, self::supported());
    }

    /**
     * Get an array of supported emulator driver names
     *
     * @throws \ReflectionException
     * @return array
     */
    public static function supported(): array
    {
        $reflection = new \ReflectionClass(static::getFacadeAccessor());

        $methods = collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED | \ReflectionMethod::IS_PRIVATE));

        return $methods->filter(function (\ReflectionMethod $method) {
            return starts_with($method->name, 'create')
                && ends_with($method->name, 'Driver');
        })->map(function (\ReflectionMethod $method) {
            $driver = str_after($method->name, 'create');

            return str_before($driver, 'Driver');
        })->filter()->values()->toArray();
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return EmulatorManager::class;
    }
}
