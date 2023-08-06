<?php

namespace Api\Post;

use Tests\TestCase;

class CreatePostTest extends TestCase
{

    public function createPostTest(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

}
