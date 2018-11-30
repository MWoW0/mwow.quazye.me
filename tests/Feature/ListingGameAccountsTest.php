<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\TestsEmulatorDatabases;
use function factory;

class ListingGameAccountsTest extends TestCase
{
    use RefreshDatabase, TestsEmulatorDatabases;

    protected function setUp()
    {
        parent::setUp();

        config([
            'services.skyfire.supported' => true,
            'services.mangos.supported' => true
        ]);

        $this->createSkyFireAuthDatabase();
        $this->createMangosAuthDatabase();
    }

    /**
     * @test
     **/
    public function playerCanListTheirGameAccounts()
    {
        /** @var User $player */
        $player = factory(User::class)->states(['player', 'with game account'])->create();

        $this
            ->actingAs($player)
            ->json('GET', '/api/game-accounts', ['player_id' => $player->id])
            ->assertSuccessful()
            ->assertJsonCount(2, 'data')
            ->assertSee($player->account_name);
    }

    /**
     * @test
     **/
    public function playerCannotListAnothersGameAccounts()
    {
        /** @var User $playerOne */
        $playerOne = factory(User::class)->states(['player', 'with game account'])->create();

        /** @var User $playerTwo */
        $playerTwo = factory(User::class)->states(['player', 'with game account'])->create();

        $this
            ->actingAs($playerOne)
            ->json('GET', '/api/game-accounts', ['player_id' => $playerOne->id])
            ->assertSuccessful()
            ->assertJsonCount(2, 'data')
            ->assertSee($playerOne->account_name)
            ->assertDontSee($playerTwo->account_name);

        $this
            ->actingAs($playerOne)
            ->json('GET', '/api/game-accounts', ['player_id' => $playerTwo->id])
            ->assertStatus(403);
    }

    /**
     * @test
     **/
    public function adminCanListAnyPlayersGameAccounts()
    {
        /** @var User $admin */
        $admin = factory(User::class)->states(['admin'])->create();

        /** @var User $player */
        $player = factory(User::class)->states(['player', 'with game account'])->create();

        $this
            ->actingAs($admin)
            ->json('GET', '/api/game-accounts', ['player_id' => $player->id])
            ->assertSuccessful()
            ->assertJsonCount(2, 'data')
            ->assertSee($player->account_name);
    }
}
