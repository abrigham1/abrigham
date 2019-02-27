<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * tests for the three demo controller
 *
 * Class ThreeDemoControllerTest
 * @package Tests\Feature
 */
class ThreeDemoControllerTest extends TestCase
{

    /**
     * test the three demo page
     */
    public function testThreeDemo()
    {
        $uri = route('three-demo', [], false);
        $response = $this->get($uri);

        // make our assertions
        $response->assertOk()
            ->assertSeeText('Three.js Demo test');
    }
}