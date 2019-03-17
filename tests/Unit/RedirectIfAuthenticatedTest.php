<?php

namespace Tests\Unit;

use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

/**
 * test redirect if authenticated
 *
 * Class RedirectIfAuthenticatedTest
 * @package Tests\Unit
 */
class RedirectIfAuthenticatedTest extends TestCase
{

    /**
     * test handle function
     *
     * @dataProvider handleProvider
     * @param $authenticated
     */
    public function testHandle($authenticated)
    {
        // set up some mocks to use
        $request = Request::create('/login', 'GET');
        $guard = Mockery::mock('Illuminate\Contracts\Auth\Guard');

        Auth::shouldReceive('guard')
            ->once()
            ->with($guard)
            ->andReturn($guard);

        $guard->shouldReceive('check')
            ->once()
            ->withNoArgs()
            ->andReturn($authenticated);

        // middleware we want to test
        $middleware = new RedirectIfAuthenticated();

        // test the handle call
        $actual = $middleware->handle($request, function() { return "test"; }, $guard);

        // if we are authenticated expect to be redirected to the homepage
        if ($authenticated) {
            $this->assertTrue(
                $actual instanceof RedirectResponse,
                'Failed asserting we have a redirect response'
            );
            $this->assertEquals(302, $actual->getStatusCode());
            $this->assertEquals(route('home'), $actual->getTargetUrl());
        } else {
            $this->assertEquals('test', $actual, 'Failed asserting that user is not authenticated');
        }
    }

    /**
     * handle data provider
     *
     * @return array
     */
    public function handleProvider()
    {
        return [
            'Authenticated' => [
                // authenticated
                true
            ],
            'Not authenticated' => [
                // authenticated
                false
            ],
        ];
    }
}
