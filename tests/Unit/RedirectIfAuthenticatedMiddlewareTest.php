<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

/**
 * test redirect if authenticated middleware
 *
 * Class RedirectIfAuthenticatedTest
 * @package Tests\Unit
 */
class RedirectIfAuthenticatedMiddlewareTest extends TestCase
{
    /**
     * test handle function
     *
     * @dataProvider handleProvider
     */
    public function testHandle(bool $authenticated): void
    {
        // set up some mocks to use
        $request = Request::create('/login', 'GET');
        $guard = Mockery::mock(Guard::class);

        Auth::shouldReceive('guard')
            ->once()
            ->with('mockGuard')
            ->andReturn($guard);

        $guard->shouldReceive('check')
            ->once()
            ->withNoArgs()
            ->andReturn($authenticated);

        // middleware we want to test
        $middleware = new RedirectIfAuthenticated();

        // test the handle call
        $actual = $middleware->handle($request, function () {
            return response('test');
        }, 'mockGuard');

        // if we are authenticated expect to be redirected to the homepage
        if ($authenticated) {
            self::assertInstanceOf(
                RedirectResponse::class,
                $actual,
                'Failed asserting we have a redirect response'
            );
            self::assertEquals(302, $actual->getStatusCode());
            self::assertEquals(route('home'), $actual->getTargetUrl());
        } else {
            self::assertEquals('test', $actual->getContent(), 'Failed asserting that user is not authenticated');
        }
    }

    /**
     * handle data provider
     *
     * @return array<string,array<int,bool>>
     */
    public function handleProvider(): array
    {
        return [
            'Authenticated' => [
                // authenticated
                true,
            ],
            'Not authenticated' => [
                // authenticated
                false,
            ],
        ];
    }
}
