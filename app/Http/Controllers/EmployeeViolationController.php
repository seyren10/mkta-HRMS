<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeViolationResource;
use App\Models\Employee;
use App\Models\EmployeeViolation;
use Illuminate\Http\Request;

class EmployeeViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EmployeeViolationResource::collection(EmployeeViolation::orderBy('created_at', 'desc')->get());
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

        $data = array_map(function ($el, $i) use ($request) {
            return [
                'employee_id' => $el,
                'violation_id' => $request->violation_id,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }, $request->employee_id, array_keys($request->employee_id));



        EmployeeViolation::insert($data);
        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeViolation $employeeViolation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeViolation $employeeViolation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeViolation $employeeViolation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeViolation $employeeViolation)
    {
        //
    }
}
