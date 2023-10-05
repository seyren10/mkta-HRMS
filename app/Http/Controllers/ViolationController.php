<?php

namespace App\Http\Controllers;

use App\Http\Resources\ViolationResource;
use App\Models\Violation;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  ViolationResource::collection(Violation::orderBy('created_at', 'desc')->get());
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
        Violation::create(
            $request->validate([
                'description' => 'required',
                'action_length' => 'required|integer',
                'violation_type_id' => 'required'
            ])
        );

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(Violation $violation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Violation $violation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Violation $violation)
    {
        $violation->update(
            $request->validate([
                'description' => 'required',
                'action_length' => 'required|integer',
                'violation_type_id' => 'required'
            ])
        );

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Violation $violation)
    {
        //
    }
}
