<?php

namespace Tests\Feature;

use App\Comment;
use App\User;
use function factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletingCommentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     **/
    public function authorCanDeleteTheirComment()
    {
        $subscriber = factory(User::class)->create();

        $comment = factory(Comment::class)->create([
            'author_id' => $subscriber->id,
        ]);

        $this
            ->actingAs($subscriber)
            ->json('DELETE', "/api/comments/{$comment->id}")
            ->assertSuccessful();

        $this->assertSoftDeleted('comments', ['id' => $comment->id]);
    }

    /**
     * @test
     **/
    public function adminCanDeleteAnyComment()
    {
        $admin = factory(User::class)->state('admin')->create();

        $comment = factory(Comment::class)->create();

        $this
            ->actingAs($admin)
            ->json('DELETE', "/api/comments/{$comment->id}")
            ->assertSuccessful();

        $this->assertSoftDeleted('comments', ['id' => $comment->id]);
    }

    /**
     * @test
     **/
    public function subscriberCannotDeleteACommentTheyDoNotOwn()
    {
        $subscriber = factory(User::class)->create();

        $comment = factory(Comment::class)->create();

        $this
            ->actingAs($subscriber)
            ->json('DELETE', "/api/comments/{$comment->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    /**
     * @test
     **/
    public function moderatorCannotDeleteACommentTheyDoNotOwn()
    {
        $moderator = factory(User::class)->state('moderator')->create();

        $comment = factory(Comment::class)->create();

        $this
            ->actingAs($moderator)
            ->json('DELETE', "/api/comments/{$comment->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }
}
