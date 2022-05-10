<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * show the homepage
     */
    public function show(): Response
    {
        return Inertia::render('Home', [
            'predictUrl' => Config::get('app.python_api_url') . '/predict',
        ]);
    }
}
