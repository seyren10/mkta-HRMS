<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\EmployeeViolation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return EmployeeResource::collection(Employee::search((string)$request->q)->get());
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
                'status' => ['required', Rule::in(['active', 'suspended', 'dismissed'])],
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
                'status' => ['required', Rule::in(['active', 'suspended', 'dismissed'])],
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
