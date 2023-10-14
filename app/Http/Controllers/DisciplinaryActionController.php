<?php

namespace App\Http\Controllers;

use App\Http\Resources\DisciplinaryActionResource;
use App\Models\DisciplinaryAction;
use Illuminate\Http\Request;

class DisciplinaryActionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DisciplinaryActionResource::collection(DisciplinaryAction::orderBy('created_at', 'desc')->get());
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DisciplinaryAction $disciplinaryAction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DisciplinaryAction $disciplinaryAction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DisciplinaryAction $disciplinaryAction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DisciplinaryAction $disciplinaryAction)
    {
        //
    }
}
