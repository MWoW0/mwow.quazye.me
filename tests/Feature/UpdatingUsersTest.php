<?php

namespace Tests\Feature;

use App\Hashing\SillySha1;
use App\User;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\HasSkyFireDatabases;
use Tests\TestCase;

class UpdatingUsersTest extends TestCase
{
	use RefreshDatabase, HasSkyFireDatabases;

    protected function setUp()
    {
        parent::setUp();

        $this->createSkyFireAuthDatabase();
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

    	$this->assertDatabaseHas('account', [
        	'sha_pass_hash' => (new SillySha1)->make('superSecretPassword', ['user' => 'john']),
    	], 'skyfire_auth');
    } 
}