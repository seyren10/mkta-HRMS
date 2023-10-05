<?php

namespace App\Http\Controllers;

use App\Http\Resources\ViolationTypeResource;
use App\Models\ViolationType;
use Illuminate\Http\Request;

class ViolationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return ViolationTypeResource::collection(ViolationType::orderBy('created_at', 'desc')->get());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ViolationType::create([
            ...$request->all(),
            ...$request->validate([
                'violation_type' => 'required|max:255',

            ])
        ]);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(ViolationType $violationType)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ViolationType $violationType)
    {
        $violationType->update([
            ...$request->all(),
            ...$request->validate([
                'violation_type' => 'required|max:255',
            ])
        ]);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ViolationType $violationType)
    {
        $violationType->delete();
        return response()->noContent();
    }
}
