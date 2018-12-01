<?php

namespace App\Jobs;

use App\Contracts\Emulator as EmulatorContract;
use App\Emulator;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function decrypt;
use function encrypt;

class CreateGameAccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Integer of the user we're creating an account for.
     *
     * @var integer
     */
    public $id;

    /**
     * The users desired password.
     *
     * @var string
     */
    public $password;

    /**
     * The emulators we're creating an account on
     *
     * @var array
     */
    public $emulators;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $password
     */
    public function __construct($user, $password)
    {
        $this->id = $user->id;
        $this->password = encrypt($password);
        $this->emulators = Emulator::collect()->mapToInstances();
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $user = User::query()->findOrFail($this->id);

        $this->emulators->each(function (EmulatorContract $emulator) use ($user) {
            $emulator->createAccount($user, decrypt($this->password));
        });
    }
}
