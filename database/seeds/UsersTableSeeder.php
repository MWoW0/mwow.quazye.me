<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\Enums\UserType::getKeys() as $key) {
            $userType = \App\Enums\UserType::getValue($key);

            /** @var \App\User $user */
            $user = factory(\App\User::class)->create([
                'email' => "{$key}@example.com",
                'account_name' => $key,
                'name' => $userType,
                'type' => $userType
            ]);

            $user->markEmailAsVerified();

//            $user->gameAccounts()->create([
//                // 'user_id',
//                'account_id' => null,
//                'realm_id' => null,
//                'emulator' => \App\Emulators\SkyFire::class
//            ]);
        }
    }
}
