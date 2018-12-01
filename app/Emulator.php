<?php

namespace App;

use App\Collections\EmulatorCollection;
use App\Contracts\Emulator as EmulatorContract;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;
use function app;
use function app_path;
use function array_merge;
use function class_basename;
use function class_exists;
use function is_subclass_of;
use function str_replace;

class Emulator
{
    /**
     * The registered Emulators
     *
     * @var array
     */
    public static $emulators = [];

    /**
     * Make a new emulator instance
     *
     * @param string $emulator
     * @return EmulatorContract
     */
    public static function make($emulator): ?EmulatorContract
    {
        if (!class_exists($emulator)) {
            $emulator = static::toClassName($emulator);
        }

        if (!$emulator) {
            return null;
        }

        return resolve($emulator);
    }

    public static function toClassName(string $emulator): ?string
    {
        return static::$emulators[$emulator] ?? null;
    }

    /**
     * Collect the registered emulators
     *
     * @return EmulatorCollection
     */
    public static function collect(): EmulatorCollection
    {
        return new EmulatorCollection(static::$emulators);
    }

    /**
     * Register given emulators
     *
     * @param array $emulators
     * @return Emulator
     */
    public static function emulators(array $emulators)
    {
        static::$emulators = array_merge(static::$emulators, $emulators);

        return new static;
    }

    /**
     * Discover the emulators in given directory
     *
     * @param string $inDirectory
     */
    public static function discover(string $inDirectory)
    {
        $namespace = app()->getNamespace();

        $emulators = [];

        foreach ((new Finder)->in($inDirectory)->files() as $emulator) {
            $emulator = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($emulator->getPathname(), app_path() . DIRECTORY_SEPARATOR)
                );

            if (is_subclass_of($emulator, EmulatorContract::class)) {
                $emulators[class_basename($emulator)] = $emulator;
            }
        }

        static::emulators($emulators);
    }
}
