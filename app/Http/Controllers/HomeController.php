<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Config;
use Inertia\Response;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{

    /**
     * show the homepage
     *
     * @return Response
     */
    public function show(): Response
    {
        return Inertia::render('Home', ['predictUrl' => Config::get('app.python_api_url') . '/predict']);
    }
}
