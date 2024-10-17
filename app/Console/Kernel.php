<?php

namespace App\Console;

use App\Http\Controllers\pdfController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Add your custom commands here
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            app(pdfController::class)->generateMonthlyPdf();
        })->dailyAt('17:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
