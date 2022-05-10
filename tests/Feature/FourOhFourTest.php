<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * tests that we can throw a 404 exception
 *
 * Class FourOhFourTest
 * @package Tests\Feature
 */
class FourOhFourTest extends TestCase
{
    /**
     * test homepage
     */
    public function testHomepage(): void
    {
        $response = $this->get('/404');

        // make our assertions
        $response->assertStatus(404);
    }
}
