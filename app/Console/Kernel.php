<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Clean up expired OTPs every hour
        $schedule->command('otp:cleanup')->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}