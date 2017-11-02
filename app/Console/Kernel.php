<?php

namespace App\Console;

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
        // Commands\Inspire::class,
        Commands\BackupDatabase::class,
        Commands\SendLogsEmailConsole::class,
        Commands\SendSalesPerformanceEmail::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('logsemail:send')->dailyAt('23:55');
        $schedule->command('backupdatabase:execute')->dailyAt('1:00');
        $schedule->command('salesperformance:send')->monthlyOn(2, '7:00');
    }
}
