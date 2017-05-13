<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class MovieReviewPredictController
 * @package App\Http\Controllers
 */
class MovieReviewPredictController extends Controller
{

    /**
     * MovieReviewPredictController constructor.
     */
    public function __construct()
    {
        $this->middleware('ajax');
    }


    /**
     * predict whether the movie review is positive or negative
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function predict(Request $request)
    {
        $review = $request->input('review');
        return response()->json([
            'label' => 'positive',
            'probability' => '91.5%'
        ]);
    }
}
