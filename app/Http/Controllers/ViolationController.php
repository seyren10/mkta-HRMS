<?php

namespace App\Http\Controllers;

use App\Http\Resources\DisciplinaryActionResource;
use App\Http\Resources\ViolationResource;
use App\Models\DisciplinaryAction;
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
        $violation =  Violation::create(
            $request->validate([
                'description' => 'required',
                'violation_type_id' => 'required'
            ])
        );

        $data = array_map(function ($el, $i) use ($violation) {
            return [
                'violation_id' => $violation->id,
                'disciplinary_measure_id' => $el,
                'offense_no' => $i + 1
            ];
        }, $request->disciplinaryActionIds, array_keys($request->disciplinaryActionIds));

        foreach ($data as $value) {
            DisciplinaryAction::create($value);
        }

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function show(Violation $violation)
    {
        return new ViolationResource($violation);
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
                'violation_type_id' => 'required'
            ])
        );
        if ($violation) {
            $updatedViolation = []; 
            $updatedViolation = $violation->fresh();

            $data = array_map(function ($el, $i) use ($updatedViolation) {
                return [
                    'violation_id' => $updatedViolation->id,
                    'disciplinary_measure_id' => $el,
                    'offense_no' => $i + 1
                ];
            }, $request->disciplinaryActionIds, array_keys($request->disciplinaryActionIds));

            //delete existing data
            $violation->disciplinaryActions()->delete();

            //create new data
            foreach ($data as $value) {
                DisciplinaryAction::create($value);
            }
        }



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
