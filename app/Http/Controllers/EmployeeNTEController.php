<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeNteResource;
use App\Models\EmployeeNte;
use Illuminate\Http\Request;

class EmployeeNTEController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EmployeeNteResource::collection(EmployeeNte::orderBy('created_at', 'desc')->get());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        EmployeeNte::create([
            ...$request->all(),
            ...$request->validate([
                'offense_type' => 'required|max:255',
                'offense_length' => 'required|integer|min:1|max:10',

            ])
        ]);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeNte $employeeNTE)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeNte $employeeNte)
    {
        $employeeNte->update([
            ...$request->all(),
            ...$request->validate([
                'offense_type' => 'required|max:255',
                'offense_length' => 'required|integer|min:1|max:10',
            ])
        ]);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeNte $employeeNTE)
    {
        $employeeNTE->delete();
        return response()->noContent();
    }
}
