<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Prototype;
use Illuminate\Support\Facades\Validator;

class PrototypeController extends Controller
{
    public function create (Request $request)
    {
       $validator= Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'model_id' => 'required|integer|exists:models,id',
            'name' => 'required|string|max:255',
            'temperature' => 'nulleable|numeric',
            'humidity' => 'nulleable|numeric',
            'dust_level' => 'nulleable|numeric',
        ])->validate();

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $prototype = Prototype::create([
            'user_id' => $request->input('user_id'),
            'model_id' => 'required|integer|exists:models,id',
            'name' => $request->input('name'),
            'temperature' => $request->input('temperature'),
            'humidity' => $request->input('humidity'),
            'dust_level' => $request->input('dust_level'),
        ]);

        return response()->json([
        'message' => 'Prototype created successfully',
        'prototype' => $prototype
    ], 201);


    }

    public function readOne (Request $request, $id)
    {
        $prototype = Prototype::find($request->input('id'));
        if (!$prototype) {
            return response()->json(['error' => 'Prototype not found'], 404);

            return response()->json($prototype);



        }

        
    }
    public function readAll (Request $request)
    {
        $prototypes = Prototype::all();
        return response()->json($prototypes);
        
    }    
    public function update (Request $request, $id)
    {
        $validator= Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
        ])->validate();

        $prototype = Prototype::find($id);
        if (!$prototype) {
            return response()->json(['error' => 'Prototype not found'], 404);
        }

        if ($request->has('name')) {
            $prototype->name = $request->input('name');
        }

        $prototype->save();
        return response()->json([
            'message' => 'Prototype updated successfully',
            'prototype' => $prototype
        ]);
    }
    
    public function delete (Request $request, $id)
    {
        $prototype = Prototype::find($id);
        if (!$prototype) {
            return response()->json(['error' => 'Prototype not found'], 404);
        }

        $prototype->delete();
        return response()->json(['message' => 'Prototype deleted successfully']);


        
    }

    public function ReadSensorData($request, $response){
        if (!$prototype) {
        return response()->json(['error' => 'Prototype not found'], 404);
    }
    
    return response()->json([
        'device_id' => $prototype->id,
        'name' => $prototype->name,
        'current_readings' => [
            'temperature' => $prototype->temperature,
            'humidity' => $prototype->humidity,
            'dust_level' => $prototype->dust_level,
        ]
    ]);
        
    }
}
