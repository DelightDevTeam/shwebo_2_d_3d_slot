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
        Commands\MorningSessionOpen::class,
        Commands\MorningPrizeStatusOpen::class,
        Commands\EveningPrizeStatusOpen::class,
        Commands\MorningPrizeStatusClose::class,
        Commands\EveningSessionOpen::class,
        Commands\EveningPrizeStatusClose::class,
        Commands\CloseMorningSession::class,
        Commands\EveningSessionClose::class,
        Commands\UpdateMatchStatus::class, // 3d
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('make:pull-report')->everyFiveSeconds();
        //$schedule->command('session:update-status')->everyFiveMinutes();
        //$schedule->command('session:twod-update-status')->oneDay();
        //$schedule->command('match:update-status')->daily();
         $schedule->command('session:morning-status-open')->daily();
        $schedule->command('session:morning-prize-status-open')->daily();
        $schedule->command('session:morning-prize-status-close')->daily();
        $schedule->command('session:evening-status-open')->daily();
        $schedule->command('session:eveing-prize-status-open')->daily();
        $schedule->command('session:evening-prize-status-close')->daily();
        $schedule->command('match:update-status')->daily();// 3d 
        $schedule->command('session:close-morning')->daily();
        $schedule->command('session:close-evening')->daily();

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
