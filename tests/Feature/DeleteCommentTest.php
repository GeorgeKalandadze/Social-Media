<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteCommentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_delete_comment_as_user(): void
    {
        $user = \App\Models\User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/comment/{$comment->id}");

        $response->assertStatus(200)
            ->assertSee('Comment deleted successfully');
    }


    public function test_delete_comment_invalid_id(): void
    {
        $user = \App\Models\User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->deleteJson("/api/comment/999"); // Assuming 999 is an invalid comment ID

        $response->assertStatus(400)
            ->assertSee('Invalid comment ID.');
    }
}
