<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Setting::all()->groupBy('type')
        ]);
    }

    public function update(Request $request)
    {
        foreach ($request->data as $data) {
            Setting::find($data['id'])->update(['value' => $data['value']]);
        }

        return response()->noContent();
    }
}
