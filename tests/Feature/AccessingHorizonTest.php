<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function factory;

class AccessingHorizonTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	function AdminCanAccessHorizon() 
	{
		$admin = factory(User::class)->state('admin')->create();

		$this
		    ->actingAs($admin, 'web')
		    ->get('/horizon')
		    ->assertSuccessful();
	}

	/** @test */
	function guestCannotAccessHorizon() 
	{
		$this
		    ->assertGuest()
		    ->get('/horizon')
		    ->assertRedirect('login');
	} 

	/** 
	 * @test
	 * @dataProvider cannotAccessHorizon
	 */
	function nonAdminsCannotAccessHorizon(string $type) 
	{
		$user = factory(User::class)->state($type)->create();

		$this
		    ->actingAs($user, 'web')
		    ->get('/horizon')
		    ->assertStatus(403);
	} 

	public function cannotAccessHorizon(): array
	{
		return [
			['player'],
			['moderator']
		];
	}
}
