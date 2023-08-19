<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;

class ToggleFavoritePostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {

        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->actingAs($user);

        $response = $this->postJson("/api/posts/{$post->id}/favorite");
        $response->assertJson(['message' => 'Post added to favorites']);
        $this->assertTrue($user->favorites->contains($post));

        $response = $this->postJson("/api/posts/{$post->id}/favorite");
        $response->assertJson(['message' => 'Post removed from favorites']);
        $this->assertFalse($user->fresh()->favorites->contains($post));
    }
}
