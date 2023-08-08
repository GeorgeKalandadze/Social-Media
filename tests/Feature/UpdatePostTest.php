<?php
namespace Api\Post;

use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class UpdatePostTest extends TestCase
{
    use WithFaker;

    public function test_owner_can_update_post(): void
    {
        $user = \App\Models\User::factory()->create();
        $post = \App\Models\Post::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user);
        $updateData = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'sub_category_id' => 2,
        ];
        $response = $this->patchJson("/api/post/update/{$post->id}", $updateData);
        $response->assertStatus(200)
            ->assertJson([
                'title' => $updateData['title'],
                'body' => $updateData['body'],
                'sub_category_id' => $updateData['sub_category_id'],
            ]);
    }

    public function test_non_owner_cannot_update_post(): void
    {
        $owner = \App\Models\User::factory()->create();
        $nonOwner = \App\Models\User::factory()->create();
        $post = \App\Models\Post::factory()->create(['user_id' => $owner->id]);
        Sanctum::actingAs($nonOwner);
        $updateData = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'sub_category_id' => 2,
        ];
        $response = $this->patchJson("/api/post/update/{$post->id}", $updateData);
        $response->assertStatus(403);
    }
}
