<?php

namespace App\Listeners;

use App\Models\Log;
use App\Events\ViolationProcessed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Resources\PendingViolationResource;

class CreateLog
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ViolationProcessed $event): void
    {
        Log::create([
            'type' => 'pendingViolation',
            'data' => json_encode(PendingViolationResource::collection($event->pendingViolation))
        ]);
    }
}
