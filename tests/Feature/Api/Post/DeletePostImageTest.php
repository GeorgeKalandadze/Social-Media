<?php

namespace Api\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DeletePostImageTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function it_deletes_post_image()
    {
        Storage::fake('public'); // Mock the storage

        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $image = $post->postImages()->create(['path' => 'path/to/image.jpg']);

        $response = $this->actingAs($user)
            ->json('DELETE', route('delete.post.image', ['postId' => $post->id, 'imageId' => $image->id]));

        $response->assertStatus(200) // HTTP OK
        ->assertJson(['message' => 'Image deleted successfully.']);

        // Assert that the image record is deleted from the database
        $this->assertDatabaseMissing('post_images', ['id' => $image->id]);

        // Assert that the image file is deleted from the storage
        Storage::disk('public')->assertMissing('post_images/' . basename($image->path));
    }

    /** @test */
    public function it_does_not_allow_unauthorized_users_to_delete_image()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $image = $post->postImages()->create(['path' => 'path/to/image.jpg']);

        $response = $this->actingAs($anotherUser)
            ->json('DELETE', route('delete.post.image', ['postId' => $post->id, 'imageId' => $image->id]));

        $response->assertStatus(403);
    }

    /** @test */
    public function it_handles_invalid_post_id()
    {
        $user = User::factory()->create();
        $imageId = 1;

        $response = $this->actingAs($user)
            ->json('DELETE', route('delete.post.image', ['postId' => 999, 'imageId' => $imageId]));

        $response->assertStatus(400) // HTTP BAD REQUEST
        ->assertJson(['message' => 'Invalid post ID.']); // Update the expected message

    }
}
