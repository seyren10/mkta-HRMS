<?php

namespace App\Http\Controllers;

use App\Models\DisciplinaryMeasure;
use Illuminate\Http\Request;

class DisciplinaryMeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => DisciplinaryMeasure::orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DisciplinaryMeasure::create([
            $request->validate(['title' => 'required'])
        ]);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(DisciplinaryMeasure $disciplinaryMeasure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DisciplinaryMeasure $disciplinaryMeasure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DisciplinaryMeasure $disciplinaryMeasure)
    {
        $disciplinaryMeasure->update([
            $request->validate(['title' => 'required'])
        ]);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DisciplinaryMeasure $disciplinaryMeasure)
    {
        //
    }
}
