<?php

namespace App\Jobs;

use App\Http\Resources\PendingViolationResource;
use App\Models\EmployeeViolation;
use App\Models\Log;
use App\Models\PendingViolation;
use App\Models\Setting;
use App\Notifications\ViolationReminder;
use App\Notifications\ViolationSuccess;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Request;

class DeletePendingViolations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pendingViolations;
    protected $user;
    /**
     * Create a new job instance.
     */
    public function __construct(Collection $pendingViolations, $user)
    {
        $this->pendingViolations = $pendingViolations;

        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!$this->pendingViolations->count())  return;

        $automaticRejection = Setting::where("name", "automaticRejection")->first();

        Request::merge(['includeViolationType' => true]);

        if ($automaticRejection->value) {
            foreach ($this->pendingViolations as $data) {
                EmployeeViolation::create([
                    'employee_id' => $data->employee_id,
                    'violation_id' => $data->violation_id
                ]);
                $data->delete();
            }

            Log::create([
                'type' => 'pendingViolation',
                'data' => json_encode(PendingViolationResource::collection($this->pendingViolations))
            ]);


            $this->user->notify(new ViolationSuccess($this->pendingViolations));
        } else
            $this->user->notify(new ViolationReminder($this->pendingViolations));
    }
}
