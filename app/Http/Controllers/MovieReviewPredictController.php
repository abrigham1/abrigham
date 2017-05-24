<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\PredictionException;

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
        // we should only hit this controller via ajax
        $this->middleware('ajax');
    }

    /**
     * predict whether the movie review is positive or negative
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws PredictionException
     */
    public function predict(Request $request)
    {
        // validate our request to make sure its good this will automatically
        // return a json response if validation fails
        $this->validate($request, [
            'review' => 'required|min:15',
        ]);

        // get a handle on our review from the request
        $review = $request->input('review');

        // the location of our python command
        $pythonCommand = env('PYTHON_INTERPRETER');

        // normalize the python command and add a space
        $pythonCommand = trim($pythonCommand).' ';


        // we forgot to set up our python interpreter location
        // in our env file throw and exception
        if (!$pythonCommand) {
            $exceptionMessage = "Can't find python interpreter please ensure its set up in the env file";
            throw new PredictionException($exceptionMessage, $request);
        }

        // the location of the script we want to run
        $pythonScript = base_path()."/MovieReviewClassifier/MovieReviewPredict.py ";

        // escape our user input so they cant run arbitrary commands on the server...that would be bad
        $pythonArg = escapeshellarg($review);

        // put our full command together
        $command = $pythonCommand.$pythonScript.$pythonArg;

        // execute the command and get the output
        $output = shell_exec($command);
        if (!preg_match('/^(positive|negative),([+-]?([0-9]*[.])?[0-9]+)$/', $output)) {
            // output doesn't match what we expect lets throw an exception
            $exceptionMessage = "There has been an error calling a shell script. OUTPUT: {$output}";
            throw new PredictionException($exceptionMessage, $request);
        }

        // lets trim the output
        $output = trim($output);
        // get our label and probability
        list($label, $probability) = explode(',', $output);

        // return it to the ajax request
        return response()->json([
            'label' => $label,
            'probability' => $probability,
        ]);
    }
}
