<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the homepage
     *
     * @return Response
     */
    public function show()
    {
        return view('home');
    }
}