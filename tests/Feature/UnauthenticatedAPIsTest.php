<?php

namespace Tests\Feature;

use Tests\TestCase;

class UnauthenticatedAPIsTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function test_home_return_success_response()
    {
        $response = $this->json('get', '/api/home');
        $response->assertStatus(200)
            ->assertJson([
                'code' => 200,
            ]);
    }

    /**
     * @runInSeparateProcess
     */
    // for brand_store page
    public function test_categories_brands_return_success_response()
    {
        $response = $this->json('get', '/api/categories-brands');
        $response->assertStatus(200)
            ->assertJson([
                'code' => 200,
            ]);
    }

}
