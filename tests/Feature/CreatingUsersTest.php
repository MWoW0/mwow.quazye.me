<?php

namespace Tests\Feature\User;

use App\Account;
use App\Contracts\Emulator as EmulatorContract;
use App\Emulator;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TestsEmulatorDatabases;
use function get_class;

class CreatingUsersTest extends TestCase
{
    use RefreshDatabase, TestsEmulatorDatabases, WithFaker;

    protected function setUp()
    {
        parent::setUp();

        config([
            'services.mangos.supported' => true
        ]);

        $this->createMangosAuthDatabases();
    }

    /**
     * @test
     */
    public function itCreatesAUserAndAGameAccountUponRegistration()
    {
        $this->postJson(
            '/register',
            [
                'account_name' => 'john',
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => 'secret',
                'password_confirmation' => 'secret'
            ]
        )->assertRedirect('/home');

        $this->assertDatabaseHas('users', [
            'account_name' => 'john',
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        foreach (Emulator::collect()->mapToInstances() as $emulator) {
            $this->assertAccountCreated('john@example.com', $emulator);
        }
    }

    private function assertAccountCreated(string $email, EmulatorContract $emulator)
    {
        $userId = User::query()->where('email', $email)->value('id');

        $this->assertDatabaseHas('account', [
            'username' => 'john',
            'sha_pass_hash' => '0639C9915279A92A5AAF84FF50FBA680B06152CF',
            'email' => 'john@example.com'
        ], $emulator->connectionName());


        $accountId = Account::connectedTo($emulator)->where('email', $email)->value('id');

        $this->assertDatabaseHas('game_accounts', [
            'user_id' => $userId,
            'account_id' => $accountId,
            //'realm_id' => $realm->id,
            'emulator' => get_class($emulator)
        ]);
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
