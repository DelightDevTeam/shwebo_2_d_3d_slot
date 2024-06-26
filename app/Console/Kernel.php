<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\PullReport::class,
        Commands\UpdateSessionStatus::class,
        //Commands\TwoDSessionStatusUpdate::class,
        Commands\CloseMorningSession::class,
        Commands\EveningSessionClose::class,
        Commands\UpdateMatchStatus::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('make:pull-report')->everyFiveSeconds();
        $schedule->command('session:update-status')->everyFiveMinutes();
        //$schedule->command('session:twod-update-status')->oneDay();
        //$schedule->command('match:update-status')->daily();
        $schedule->command('match:update-status')->everyMinute();
        $schedule->command('session:close-morning')->everyMinute();
        $schedule->command('session:close-evening')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
