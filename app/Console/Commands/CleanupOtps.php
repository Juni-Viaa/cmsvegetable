<?php

namespace App\Console\Commands;

use App\Models\OtpVerification;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanupOtps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-otps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired OTPs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = OtpVerification::where('expires_at', '<', Carbon::now())->delete();
        $this->info("Deleted {$count} expired OTPs");
    }
}
