<?php

namespace Tests\Browser;

use Illuminate\Support\Facades\Config;
use Tests\Browser\Pages\MovieReview;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MovieReviewTest extends DuskTestCase
{
    /**
     * Test movie review page
     *
     * @throws \Throwable
     */
    public function testMovieReviewPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new MovieReview)
                    ->assertSee('Machine Learning with Scikit Learn');
        });
    }

    /**
     * test movie review empty
     *
     * @throws \Throwable
     */
    public function testMovieReviewEmpty()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new MovieReview)
                ->click('@submit-review')
                ->waitForText('Review is a required field', 10)
                ->assertSee('Review is a required field');
        });
    }

    /**
     * test a too short movie review
     *
     * @throws \Throwable
     */
    public function testMovieReviewTooShort()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new MovieReview)
                ->type('@review', 'small review')
                ->click('@submit-review')
                ->waitForText('Review must be at least 15 characters', 10)
                ->assertSee('Review must be at least 15 characters');
        });
    }

    /**
     * test successful movie review
     *
     * @throws \Throwable
     */
    public function testMovieReviewSuccess()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new MovieReview)
                ->type('@review', 'Test to see if reviews still work.')
                ->assertDontSee('Review must be at least 15 characters')
                ->assertDontSee('Review is a required field')
                ->click('@submit-review')
                ->waitFor('@results', 10)
                ->assertSeeIn('@results', 'The review is negative, I\'m 57.44% sure.');
        });

    }
}
