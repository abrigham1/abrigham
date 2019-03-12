<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
    public function testHomepage()
    {
        $uri = route('home', [], false);
        $response = $this->get($uri);

        // make our assertions
        $response->assertOk()
            ->assertSeeText("Machine Learning with Scikit Learn");
    }
}
