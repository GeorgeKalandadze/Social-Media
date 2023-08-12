<?php

namespace Api\Post;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    use DatabaseTransactions;

    public function testAuthorizedUserCanDeletePost()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->delete("api/post/{$post->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

//    public function testAdminCanDeletePost()
//    {
//        $admin = User::factory()->create();
//        $admin->assignRole('admin');
//
//        $user = User::factory()->create();
//
//        $post = Post::factory()->create(['user_id' => $user->id]);
//
//        $response = $this->actingAs($admin)
//            ->delete("/api/post/{$post->id}");
//
//        $response->assertStatus(200);
//        $this->assertSoftDeleted('posts', ['id' => $post->id]);
//    }

}
