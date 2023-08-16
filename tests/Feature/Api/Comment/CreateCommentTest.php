<?php

namespace Api\Comment;

use App\Models\Post;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateCommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = \App\Models\User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);
        $commentData = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'body' => 'this is my firs comment',
            'parent_comment_id' => null,
        ];
        $response = $this->postJson('/api/comment/create', $commentData);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'user',
                    'post_id',
                    'body',
                    'parent_comment_id']
            ]);

        dump($response->json());

    }
}
