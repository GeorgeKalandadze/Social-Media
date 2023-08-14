<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateCommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_comment(): void
    {
        $user = \App\Models\User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $updatedBody = 'Updated comment body';
        $response = $this->putJson("/api/comment/{$comment->id}", [
            'body' => $updatedBody,
            'post_id' => $comment->post_id
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'body' => $updatedBody,
            ]);
    }
}


