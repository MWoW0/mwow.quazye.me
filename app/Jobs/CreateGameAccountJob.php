<?php

namespace App\Jobs;

use App\Account;
use App\Contracts\Emulator as EmulatorContract;
use App\Emulators\EmulatorManager;
use App\Facades\Emulator;
use App\GameAccount;
use App\Hashing\SillySha1;
use App\Realm;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function get_class;

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
     */
    public function __construct($user, $password)
    {
        $this->id = $user->id;
        $this->password = $password;
        $this->emulators = Emulator::getSupportedDrivers();
    }

    /**
     * Execute the job.
     *
     * @param EmulatorManager|null $manager
     */
    public function handle(EmulatorManager $manager = null)
    {
        $manager = $manager ?? resolve(EmulatorManager::class);
        /** @var User $user */
        $user = User::query()->findOrFail($this->id);

        foreach ($this->emulators as $emulator) {
            /** @var EmulatorContract $driver */
            $driver = $manager->driver($emulator);

            /** @var Account $account */
            $account = Account::firstOrCreateWithEmulator($driver, [
                'last_login' => now(),
                'username' => $user->account_name,
                'email' => $user->email,
                'sha_pass_hash' => (new SillySha1)->make($this->password, ['account' => $user->account_name]),
            ]);

            Realm::makeWithEmulator($driver)
                ->orderBy('id')
                ->each(function ($realm) use ($account, $user, $driver) {
                    GameAccount::query()->firstOrCreate([
                        'user_id' => $user->id,
                        'account_id' => $account->id,
                        'realm_id' => $realm->id,
                        'emulator' => get_class($driver)
                    ]);
                });
        }
    }
}
