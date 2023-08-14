<?php

namespace Api\Post;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;

class CreatePostTest extends TestCase
{
    use WithFaker;

    public function test_example(): void
    {
        $user = \App\Models\User::factory()->create();
        Sanctum::actingAs($user);

        $imageFiles = [];
        for ($i = 0; $i < 5; $i++) {
            $extension = $this->faker->randomElement(['jpg', 'jpeg', 'png']);
            $image = UploadedFile::fake()->create("image{$i}.{$extension}");
            $imageFiles[] = $image;
        }

        $postData = [
            'title' => 'Test Post Title',
            'body' => 'Test Post Body',
            'sub_category_id' => 1,
            'images' => $imageFiles,
        ];

        $response = $this->postJson('/api/post/create', $postData);
        $response->assertStatus(201)
        ->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'slug',
                'body',
                'subcategory'
            ],
        ]);

        dump($response->json());
    }
}


