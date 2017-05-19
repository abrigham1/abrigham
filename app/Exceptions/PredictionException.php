<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\UrlGenerator;

class PredictionException extends Exception
{
    /**
     * The recommended response to send to the client.
     *
     * @var \Symfony\Component\HttpFoundation\Response|null
     */
    public $response;

    /**
     * PredictionException constructor.
     *
     * @param string $message
     * @param Request $request
     * @param null $response
     */
    public function __construct($message, Request $request, $response = null)
    {
        // call parent construct
        parent::__construct($message);

        // our error message for the user
        $errorMessage = 'An error occurred attempting to get your prediction, '
            .'sorry for the inconvenience try back later.';
        if ($request->expectsJson()) {
            // if we expect json back then return a json response
            $this->response = new JsonResponse(['error' => $errorMessage], 422);
        } else {
            // otherwise we are redirecting
            $this->response = redirect()->to($this->getRedirectUrl())
                ->withInput($request->input())
                ->withErrors(['error' => $errorMessage]);
        }
    }

    /**
     * get the response
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get the URL we should redirect to.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return app(UrlGenerator::class)->previous();
    }
}