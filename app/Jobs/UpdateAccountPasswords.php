<?php

namespace App\Jobs;

use App\Account;
use App\Emulator;
use App\GameAccount;
use App\Hashing\Sha1Hasher;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAccountPasswords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $password = null;
    public $accounts = [];

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $password
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->password = (new Sha1Hasher)->make($password, ['user' => $user->account_name]);
        $this->accounts = $user->gameAccounts->mapToGroups(function (GameAccount $account) {
            return [$account->emulator => $account->account_id];
        });
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->accounts as $emulator => $ids) {
            Account::connectedTo(Emulator::make($emulator))
                ->whereIn('id', $ids)
                ->update([
                    'sha_pass_hash' => $this->password
                ]);
        }
    }
}
