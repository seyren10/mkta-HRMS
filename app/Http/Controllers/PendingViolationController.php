<?php

namespace App\Http\Controllers;

use App\Http\Resources\PendingViolationResource;
use App\Models\Employee;
use App\Models\PendingViolation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        $dataArray = array_map(function ($el, $i) use ($request) {
            return [
                'employee_id' => $el,
                'violation_id' => $request->violation_id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $request->employee_id, array_keys($request->employee_id));



        PendingViolation::insert($dataArray);
        return response()->json();
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
