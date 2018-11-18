<?php

namespace Tests\Feature;

use App\Comment;
use App\User;
use function factory;
use function str_repeat;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatingCommentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     **/
    public function authorCanUpdateTheirComment()
    {
        $subscriber = factory(User::class)->create();

        $comment = factory(Comment::class)->create(['author_id' => $subscriber->id]);

        $this
            ->actingAs($subscriber)
            ->json('PUT', "/api/comments/{$comment->id}", [
                'title' => 'hello',
                'body' => 'world'
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('comments', [
           'id' => $comment->id,
           'author_id' => $subscriber->id,
           'title' => 'hello',
           'body' => 'world'
        ]);
    }

    /**
     * @test
     **/
    public function moderatorCanUpdateAnyComment()
    {
        $moderator = factory(User::class)->state('moderator')->create();

        $comment = factory(Comment::class)->create();

        $this
            ->actingAs($moderator)
            ->json('PUT', "/api/comments/{$comment->id}", [
                'title' => 'hello',
                'body' => 'world'
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'author_id' => $comment->author_id,
            'title' => 'hello',
            'body' => 'world'
        ]);
    }

    /**
     * @test
     **/
    public function adminCanUpdateAnyComment()
    {
        $admin = factory(User::class)->state('admin')->create();

        $comment = factory(Comment::class)->create();

        $this
            ->actingAs($admin)
            ->json('PUT', "/api/comments/{$comment->id}", [
                'title' => 'hello',
                'body' => 'world'
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'author_id' => $comment->author_id,
            'title' => 'hello',
            'body' => 'world'
        ]);
    }

    /**
     * @test
     **/
    public function subscriberCannotUpdateACommentTheyDoNotOwn()
    {
        $subscriber = factory(User::class)->create();

        $comment = factory(Comment::class)->create();

        $this
            ->actingAs($subscriber)
            ->json('PUT', "/api/comments/{$comment->id}", [
                'title' => 'hello',
                'body' => 'world'
            ])
            ->assertStatus(403);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
            'title' => 'hello',
            'body' => 'world'
        ]);
    }

    /**
     * @test
     **/
    public function canChangeTitleToNull()
    {
        $subscriber = factory(User::class)->create();

        $comment = factory(Comment::class)->create(['author_id' => $subscriber->id]);

        $this
            ->actingAs($subscriber)
            ->json('PUT', "/api/comments/{$comment->id}", [
                'title' => null,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'author_id' => $subscriber->id,
            'title' => null,
        ]);
    }

    /**
     * @test
     **/
    public function validationFailsIfTitleIsLongerThan254Characters()
    {
        $subscriber = factory(User::class)->create();

        $comment = factory(Comment::class)->create(['author_id' => $subscriber->id]);

        $this
            ->actingAs($subscriber)
            ->json('PUT', "/api/comments/{$comment->id}", [
                'title' => $title = str_repeat('A', 255),
            ])
            ->assertJsonValidationErrors('title');

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
            'title' => $title,
        ]);
    }

    /**
     * @test
     **/
    public function validationFailsIfTitleIsLessThan3Characters()
    {
        $subscriber = factory(User::class)->create();

        $comment = factory(Comment::class)->create(['author_id' => $subscriber->id]);

        $this
            ->actingAs($subscriber)
            ->json('PUT', "/api/comments/{$comment->id}", [
                'title' => 'AA'
            ])
            ->assertJsonValidationErrors('title');

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
            'title' => 'AA',
        ]);
    }

    /**
     * @test
     **/
    public function validationFailsIfBodyIsLessThan3Characters()
    {
        $subscriber = factory(User::class)->create();

        $comment = factory(Comment::class)->create(['author_id' => $subscriber->id]);

        $this
            ->actingAs($subscriber)
            ->json('PUT', "/api/comments/{$comment->id}", [
                'body' => 'AA'
            ])
            ->assertJsonValidationErrors('body');

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
            'body' => 'AA',
        ]);
    }


    /**
     * @test
     **/
    public function validationFailsIfBodyIsLongerThan254Characters()
    {
        $subscriber = factory(User::class)->create();

        $comment = factory(Comment::class)->create(['author_id' => $subscriber->id]);

        $this
            ->actingAs($subscriber)
            ->json('PUT', "/api/comments/{$comment->id}", [
                'body' => $body = str_repeat('A', 255),
            ])
            ->assertJsonValidationErrors('body');

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
            'body' => $body,
        ]);
    }
}
