<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * tests for the home controller
 *
 * Class HomeControllerTest
 * @package Tests\Feature
 */
class HomeControllerTest extends TestCase
{
    /**
     * test homepage
     */
    public function testHomepage(): void
    {
        $uri = route('home', [], false);
        $response = $this->get($uri);

        // make our assertions
        $response->assertOk();
    }
}
