<?php

namespace Tests\Feature;

use App\Emulator;
use App\Hashing\Sha1Hasher;
use App\User;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestsEmulatorDatabases;

class UpdatingUsersTest extends TestCase
{
    use RefreshDatabase, TestsEmulatorDatabases;

    protected function setUp()
    {
        parent::setUp();

        $this->createMangosAuthDatabases();
    }

    /** @test */
    function itUpdatesTheGameAccountPasswordsAlongTheUsers() 
    {
    	$user = factory(User::class)->states(['player', 'with game account'])->create([
    		'email' => 'john@example.com',
    		'account_name' => 'john'
    	]);

    	$token = resolve(PasswordBroker::class)->createToken($user);

    	$this
    		->assertGuest()
    		->json('Post','/password/reset', [
    			'email' => 'john@example.com',
    			'password' => 'superSecretPassword', 
    			'password_confirmation' => 'superSecretPassword', 
    			'token' => $token
    		])
    		->assertRedirect('/home');

        $password = (new Sha1Hasher)->make('superSecretPassword', ['user' => 'john']);
        foreach (Emulator::collect()->mapToInstances() as $emulator) {
            $this->assertDatabaseHas('account', [
                'sha_pass_hash' => $password
            ], $emulator->connectionName());
        }
    } 
}
