<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeEmulatorCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:emulator {name} {--force} {--expansion=} --{--core=mangos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new emulator';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Emulator';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $result = parent::handle();

        if ($result === false) {
            return false;
        }

        $addDbConnection = $this->anticipate('Do you want to add a db connection?', ['Yes', 'No'], 'No');

        if (Str::startsWith($addDbConnection, 'Y')) {
            $entry = $this->buildDbConnection();

            $this->info('Add the following to your database.php config file.');
            $this->line($entry);
        }
    }

    protected function buildDbConnection()
    {
        $stub = $this->files->get($this->getDbConnectionStub());

        $stub = $this->replaceCore($stub, Str::upper($this->option('core')));
        return $this->replaceExpansion($stub, Str::upper($this->option('expansion')));
    }

    protected function getDbConnectionStub()
    {
        return __DIR__ . '/stubs/emulator.db_connection.stub';
    }

    /**
     * Replace the core name for the given stub.
     *
     * @param  string $stub
     * @param  string $core
     * @return string
     */
    protected function replaceCore($stub, $core)
    {
        return str_replace('DummyCore', $core, $stub);
    }

    /**
     * Replace the expansion for the given stub.
     *
     * @param  string $stub
     * @param  string $expansion
     * @return string
     */
    protected function replaceExpansion($stub, $expansion)
    {
        return str_replace('DummyExpansion', $expansion, $stub);
    }

    /**
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/emulator.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Emulators';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $stub = $this->replaceCore($stub, $this->option('core'));
        return $this->replaceExpansion($stub, $this->option('expansion'));
    }
}
