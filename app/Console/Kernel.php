<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array<string>
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @codeCoverageIgnore
     */
    protected function schedule(Schedule $schedule)
    {
        if ($this->app->environment('local')) {
            $schedule->command('telescope:prune --hours=48')->daily();
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
