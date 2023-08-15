<?php

namespace Api\Comment;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetCommentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_comments(): void
    {
        $user = \App\Models\User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson("/api/comment/{$post->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'body',
                        'user_name',
                        'replies' => [
                            '*' => [
                                'id',
                                'body',
                                'user_name',
                                'replies',
                            ],
                        ],
                    ],
                ],
            ]);

        dump($response);
    }
}

