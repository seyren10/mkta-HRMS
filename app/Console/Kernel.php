<?php

namespace App\Console;

use App\Models\PendingViolation;
use App\Models\User;
use App\Notifications\ViolationSuccess;
use Exception;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        try {
            // $schedule->command('inspire')->day
            $schedule->call(function () {
                $pendingViolations = PendingViolation::where('created_at', '<', now()->subSeconds(10))->get();
                User::find(1)->notifications()->delete();
                User::find(1)->notify(new ViolationSuccess($pendingViolations));
            })->everyFiveSeconds();
        } catch (Exception $e) {
            Log::error('Scheduled task error:' . $e->getMessage());
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
