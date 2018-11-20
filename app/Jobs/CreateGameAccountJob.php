<?php

namespace App\Jobs;

use App\Account;
use App\Contracts\Emulator;
use App\Emulators\EmulatorManager;
use App\GameAccount;
use App\Hashing\SillySha1;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateGameAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * @param array $emulators
     */
    public function __construct($user, $password, array $emulators = ['SkyFire'])
    {
        $this->id = $user->id;
        $this->password = $password;
        $this->emulators = $emulators;
    }

    /**
     * Execute the job.
     *
     * @param EmulatorManager $manager
     */
    public function handle(EmulatorManager $manager)
    {
        try {
            /** @var User $user */
            $user = User::query()->findOrFail($this->id);

            foreach ($this->emulators as $emulator) {
                /** @var Emulator $driver */
                $driver = $manager->driver($emulator);

                $account = Account::createWithEmulator($driver, [
                    'last_login' => now(),
                    'username' => $user->account_name,
                    'email' => $user->email,
                    'sha_pass_hash' => (new SillySha1)->make($this->password, ['user' => $user->account_name]),
                ]);

                $driver
                    ->database()
                    ->auth()
                    ->table('realmlist')
                    ->orderBy('id')
                    ->each(function ($realm) use ($account, $user, $driver) {
                        GameAccount::link($account, $user)
                            ->onRealm($realm)
                            ->through($driver)
                            ->save();
                    });
            }
        } catch (\Exception $e) {
            dd($e);
            $this->fail($e);
        }
    }
}
