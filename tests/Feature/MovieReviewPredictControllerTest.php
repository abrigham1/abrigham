<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MovieReviewPredictControllerTest extends TestCase
{

    /**
     * test predict
     *
     * @dataProvider predictProvider
     * @param $review
     * @param $status
     * @param $jsonResponse
     */
    public function testPredict($review, $status, $jsonResponse)
    {
        // get our uri using the route helper
        $uri = route('predict-review', [], false);

        // call the predict route
        $response = $this->withHeaders(
            [
                // requested with ajax
                'X-Requested-With' => 'XMLHttpRequest',
            ]
        )->json(
            'POST',
            $uri,
            [
                // our csrf token
                '_token' => csrf_token(),
                // pass our review in
                'review' => $review,
            ]
        );

        // we expect a json response back cause
        // this is an ajax route
        $response
            ->assertStatus($status)
            ->assertJson($jsonResponse);

    }

    /**
     * predict data provider
     *
     * @return array
     */
    public function predictProvider()
    {
        return [
            'no review' => [
                // review
                '',
                // status
                422,
                // json response
                [
                    "message" => "The given data was invalid.",
                    "errors" =>
                        [
                            "review" =>
                                [
                                    "The review field is required.",
                                ],
                        ],
                ],
            ],
            'review not long enough' => [
                'test',
                // status
                422,
                // json response
                [
                    "message" => "The given data was invalid.",
                    "errors" =>
                        [
                            "review" =>
                                [
                                    "The review must be at least 15 characters.",
                                ],
                        ],
                ],
                ["review" => ["The review must be at least 15 characters."]],
            ],
            'review successful' => [
                // review
                'The movie was the best movie I\'ve ever seen',
                // status
                200,
                // json response
                [
                    'label' => 'positive',
                    'probability' => '98.62',
                ],
            ],
        ];
    }

    /**
     * test predict with no ajax
     */
    public function testPredictNoAjax()
    {
        // get our uri using the route helper
        $uri = route('predict-review', [], false);

        // set up our fake review
        $review = 'This was my favorite movie of the year!';

        // call without ajax
        $response = $this->post($uri, ['review' => $review]);

        // should get a 422 status method not allowed
        $response
            ->assertStatus(405);

    }
}
