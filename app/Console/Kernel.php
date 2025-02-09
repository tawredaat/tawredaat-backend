<?php

namespace App\Console;

use Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\sendsubscriptionalertemail::class,
        Commands\Day15Exp::class,
        Commands\DayExp90::class,
        Commands\endDayExp::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('subscription:sendalert')->monthly();
        $schedule->command('exp15')->daily();
        $schedule->command('exp90')->daily();
        $schedule->command('endexp')->daily();
        // $schedule->command('cache:clear')->daily();
        // $schedule->exec('php artisan cache:clear')->daily();
        $schedule->command('queue:work --daemon')->everyMinute()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
