<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentCollection;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new DepartmentCollection(Department::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Department::create([
            ...$request->all(),
            ...$request->validate([
                'title' => 'required',
                'division' => 'in:production,office'
            ])
        ]);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $department->update([
            ...$request->all(),
            ...$request->validate([
                'title' => 'required'
            ])
        ]);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->noContent();
    }
}
