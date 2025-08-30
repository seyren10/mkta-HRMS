<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PendingViolation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ViolationSuccess;
use Illuminate\Support\Facades\Notification;
use App\Http\Resources\PendingViolationResource;
use App\Jobs\DeletePendingViolations;
use App\Models\Employee;
use App\Models\Violation;
use Illuminate\Database\Eloquent\Collection;

class PendingViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PendingViolationResource::collection(PendingViolation::orderBy('created_at', 'desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = [
            ...$request->all(),
            ...$request->validate([
                'employee_id' => 'required|array',
                'violation_id' => 'required|integer',
            ])
        ];

        $storedPendingViolations = new Collection();

        $employees = Employee::whereIn('id', $request->employee_id)
            ->withCount(['employeeViolations as filtered_violations_count' => function ($query) use ($request) {
                $query->where('violation_id', $request->violation_id);
            }])
            ->get();

        $violation = Violation::withCount('disciplinaryActions')->find($request->violation_id);

        foreach ($employees as $employee) {
            $employeeViolationCount = $employee->filtered_violations_count;


            if ($employeeViolationCount >= $violation->disciplinary_actions_count) {
                continue;
            }

            $storedPendingViolations->push(
                PendingViolation::create([
                    'employee_id' => $employee->id,
                    'violation_id' => $request->violation_id,
                ])
            );
        }

        DeletePendingViolations::dispatch($storedPendingViolations, Auth::user())->delay(now()->addSeconds(20));


        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(PendingViolation $pendingViolation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PendingViolation $pendingViolation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PendingViolation $pendingViolation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $idsToDelete = explode(',', $request->ids);

        PendingViolation::whereIn('id', $idsToDelete)->delete();

        return response()->noContent();
    }
}
