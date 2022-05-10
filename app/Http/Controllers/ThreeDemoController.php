<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

/**
 * Class ThreeDemoController
 * @package App\Http\Controllers
 */
class ThreeDemoController extends Controller
{
    /**
     * show the three demo
     */
    public function show(): Response
    {
        return Inertia::render('ThreeDemo');
    }
}
