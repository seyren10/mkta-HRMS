<?php

namespace App\Jobs;

use App\Models\EmployeeViolation;
use App\Models\PendingViolation;
use App\Notifications\ViolationSuccess;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class DeletePendingViolations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pendingViolations;
    protected $user;
    /**
     * Create a new job instance.
     */
    public function __construct(array $pendingViolations, $user)
    {
        $this->pendingViolations = $pendingViolations;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pendingViolations = PendingViolation::whereIn('employee_id', $this->pendingViolations)->get();
        foreach ($pendingViolations as $data) {
            EmployeeViolation::create([
                'employee_id' => $data->employee_id,
                'violation_id' => $data->violation_id
            ]);
        }

        PendingViolation::whereIn('employee_id', $this->pendingViolations)->delete();

        $this->user->notify(new ViolationSuccess($pendingViolations));
    }
}
