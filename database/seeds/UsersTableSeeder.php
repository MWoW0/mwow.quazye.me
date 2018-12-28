<?php

use Illuminate\Database\Seeder;
use App\Enums\UserType;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (UserType::getValues() as $type) {
            $user = factory(User::class)->create([
                'type' => $type,
                'name' => $type,
                'account_name' => $type,
                'email' => "{$type}@example.com",
            ]);

            (new \App\Jobs\CreateGameAccount($user, 'secret'))->handle();
        }
    }
}
