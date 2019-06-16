<?php

namespace Tests\Browser;

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
                ->waitForText('The review field is required.')
                ->assertSee('The review field is required.');
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
                ->waitForText('The review field must be at least 15 characters.')
                ->assertSee('The review field must be at least 15 characters.');
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
                ->assertDontSee('The review field must be at least 15 characters.')
                ->assertDontSee('The review field is required.')
                ->click('@submit-review')
                ->waitFor('@results-modal', 10)
                ->assertSeeIn('@results-modal', 'The review is negative, I\'m 57.44% sure.');
        });

    }
}
