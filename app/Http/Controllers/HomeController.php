<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * show the homepage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('home');
    }
}