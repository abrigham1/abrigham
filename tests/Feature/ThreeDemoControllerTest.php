<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHomepage()
    {
        $uri = route('three-demo', [], false);
        $response = $this->get($uri);

        $response->assertStatus(200);
    }
}