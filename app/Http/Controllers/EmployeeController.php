<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EmployeeResource::collection(Employee::orderBy('created_at', 'desc')->get());
    }

    public function show(Employee $employee)
    {
        return new EmployeeResource($employee);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Employee::create([
            ...$request->all(),
            ...$request->validate([
                'employee_id' => 'required',
                'first_name' => 'required|string|max:20',
                'last_name' => 'required|string|max:20',
                'hired_date' => 'required|date',
                'is_active' => 'required|boolean',
                'department_id' => 'required|integer'
            ]),
        ]);

        return response()->noContent();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $employee->update([
            ...$request->all(),
            ...$request->validate([
                'employee_id' => 'required',
                'first_name' => 'required|string|max:20',
                'last_name' => 'required|string|max:20',
                'hired_date' => 'required|date',
                'is_active' => 'required|boolean',
                'department_id' => 'required|integer'
            ]),
        ]);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
