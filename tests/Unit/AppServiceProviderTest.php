<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Providers\AppServiceProvider;
use App\Providers\TelescopeServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Mockery;
use Tests\TestCase;

/**
 * test app service provider
 *
 * Class AppServiceProviderTest
 * @package Tests\Unit
 */
class AppServiceProviderTest extends TestCase
{
    /**
     * test register on local
     */
    public function testRegisterOnLocal(): void
    {
        $mockApp = Mockery::mock(Application::class);
        $appServiceProvider = new AppServiceProvider($mockApp);

        $mockApp->shouldReceive('environment')
            ->once()
            ->with('local')
            ->andReturn(true);
        $mockApp->shouldReceive('register')
            ->once()
            ->with(\Laravel\Telescope\TelescopeServiceProvider::class);
        $mockApp->shouldReceive('register')
            ->once()
            ->with(TelescopeServiceProvider::class);
        $mockApp->shouldReceive('register')
            ->once()
            ->with(IdeHelperServiceProvider::class);

        $appServiceProvider->register();
    }

    /**
     * test register on anything other then local
     */
    public function testRegisterNotLocal(): void
    {
        $mockApp = Mockery::mock(Application::class);
        $appServiceProvider = new AppServiceProvider($mockApp);

        $mockApp->shouldReceive('environment')
            ->once()
            ->with('local')
            ->andReturn(false);
        $mockApp->shouldNotReceive('register');

        $appServiceProvider->register();
    }
}
