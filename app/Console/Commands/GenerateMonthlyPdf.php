<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\GuruPiket\AbsenKelasController; // Update this path based on your structure
use App\Models\absensi;

class GenerateMonthlyPdf extends Command
{
    protected $signature = 'generate:monthly-pdf';
    protected $description = 'Generate Monthly Attendance PDF';

    public function handle()
    {
        // Call the method from your controller
        app(absensi::class)->generateMonthlyPdf();

        $this->info('Monthly PDF generated successfully.');
    }
}
