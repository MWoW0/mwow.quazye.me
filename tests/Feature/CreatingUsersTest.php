<?php

namespace Tests\Feature\User;

use App\Account;
use App\User;
use function config;
use function file_get_contents;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CreatingUsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp()
    {
        parent::setUp();

        config(['database.connections.skyfire_auth' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', false),
        ]]);

        DB::connection('skyfire_auth')->unprepared(file_get_contents(__DIR__ . '/../Fixtures/skyfire_auth_sqlite3.sql'));
    }

    /**
     * @test
     */
    public function itCreatesAUserAndAGameAccountUponRegistration()
    {
        $accountName = $this->faker()->firstName;
        $email = $this->faker()->email;

        $this->postJson(
            '/register',
            [
                'account_name' => $accountName,
                'name' => 'John Doe',
                'email' => $email,
                'password' => 'secret',
                'password_confirmation' => 'secret'
            ]
        )->assertRedirect('/home');

        $this->assertDatabaseHas('users', [
            'account_name' => $accountName,
            'name' => 'John Doe',
            'email' => $email
        ]);

        $this->assertDatabaseHas('account', [
            'username' => $accountName,
            'email' => $email
        ], 'skyfire_auth');

        $user = User::where('email', $email)->with('gameAccounts')->first();
        $this->assertNotNull($user->gameAccounts->first()->account_id);

        // Clean up the newly created account on the skyfire_auth database.
        Account::query()->whereKey($user->gameAccounts->first()->account_id)->delete();
    }

    /**
     * @test
     */
    public function accountNameCannotBeLongerThan16Letters()
    {
        $this->json('POST', '/register', [
            'account_name' => 'jessieIsASexyDevil',
            'name' => 'Jessie Doe',
            'email' => 'jessie@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])->assertJsonValidationErrors('account_name');

        $this->assertDatabaseMissing('users', [
            'account_name' => 'jessieIsASexyDevil',
            'name' => 'Jessie Doe',
            'email' => 'jessie@example.com'
        ]);
    }

    /**
     * @test
     */
    public function accountNameCannotContainNumbers()
    {
        $this->json('POST', '/register', [
            'account_name' => 'jessie1234',
            'name' => 'Jessie Doe',
            'email' => 'jessie@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])->assertJsonValidationErrors('account_name');

        $this->assertDatabaseMissing('users', [
            'account_name' => 'jessie1234',
            'name' => 'Jessie Doe',
            'email' => 'jessie@example.com'
        ]);
    }
}
