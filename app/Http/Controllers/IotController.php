<?php

namespace App\Http\Controllers;

use App\Models\Iot;
use Illuminate\Http\Request;

class IotController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'light' => 'required|numeric',
        ]);

        $iot = Iot::create([
            'device_name' => $request->input('device_name'),
            'user_id' => $request->input('user_id'),
            'status' => $request->input('status'),
            'location' => $request->input('location'),
            'co2_level' => $request->input('co2_level'),
            'temperature' => $request->input('temperature'),
            'humidity' => $request->input('humidity'),
        ]);

        return response()->json([
            'message' => 'Datos del dispositivo IoT guardados con éxito',
            'data' => $iot,
        ], 201);
    }

    public function index()
    {
        $iotData = Iot::all();

        return response()->json([
            'message' => 'Datos de dispositivos IoT obtenidos con éxito',
            'data' => $iotData,
        ], 200);
    }
}
/*
        'device_name',
        'user_id',
        'status',
        'location',
        'co2_level',
        'temperature',
        'humidity',

*/
