<?php

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
    public function testHomepage()
    {
        $response = $this->get('/404');

        // make our assertions
        $response->assertStatus(404);
    }
}