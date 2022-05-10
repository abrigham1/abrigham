<?php

namespace Tests\Feature;

use Tests\TestCase;

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
    public function testThreeDemo(): void
    {
        $uri = route('three-demo', [], false);
        $response = $this->get($uri);

        // make our assertions
        $response->assertOk();
    }
}
