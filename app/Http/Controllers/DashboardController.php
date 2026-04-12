<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $firebaseUrl = 'https://airconnect-f6bdc-default-rtdb.firebaseio.com/lecturas.json';

        try {
            $json = file_get_contents($firebaseUrl);
            $lecturas = json_decode($json, true);

            // Si no hay datos
            if (!$lecturas || !is_array($lecturas)) {
                return view('dashboard', [
                    'ultima' => [],
                    'ultimasLecturas' => [],
                    'chartLabels' => [],
                    'pm25Data' => [],
                    'co2Data' => []
                ]);
            }

            // 🔥 Reindexar para evitar keys raras de Firebase
            $lecturas = array_values($lecturas);

            // 🔥 Última lectura
            $ultima = end($lecturas);

            // 🔥 Últimas 10
            $ultimasLecturas = array_slice($lecturas, -10);

            // 🔥 Datos para gráfica
            $chartLabels = [];
            $pm25Data = [];
            $co2Data = [];
            $contador = 1;

            foreach ($ultimasLecturas as $lectura) {
                $chartLabels[] = 'L' . $contador++;
                $pm25Data[] = $lectura['aire_mq135'] ?? 0;
                $co2Data[] = $lectura['co_mq7'] ?? 0;
            }

            return view('dashboard', compact(
                'ultima',
                'ultimasLecturas',
                'chartLabels',
                'pm25Data',
                'co2Data'
            ));

        } catch (\Exception $e) {
            return view('dashboard', [
                'ultima' => [],
                'ultimasLecturas' => [],
                'chartLabels' => [],
                'pm25Data' => [],
                'co2Data' => []
            ])->with('error', 'No se pudieron cargar las lecturas de Firebase');
        }
    }
    public function getUltimasLecturas()
{
    $firebaseUrl = 'https://airconnect-f6bdc-default-rtdb.firebaseio.com/lecturas.json';
    
    try {
        $json = file_get_contents($firebaseUrl);
        $lecturas = json_decode($json, true);
        
        if (!$lecturas || !is_array($lecturas)) {
            return response()->json(['success' => false, 'message' => 'No hay datos']);
        }
        
        $lecturas = array_values($lecturas);
        $ultima = end($lecturas);
        $ultimasLecturas = array_slice($lecturas, -10);
        
        $chartLabels = [];
        $pm25Data = [];
        $co2Data = [];
        $contador = 1;
        
        foreach ($ultimasLecturas as $lectura) {
            $chartLabels[] = 'L' . $contador++;
            $pm25Data[] = $lectura['aire_mq135'] ?? 0;
            $co2Data[] = $lectura['co_mq7'] ?? 0;
        }
        
        return response()->json([
            'success' => true,
            'ultima' => $ultima,
            'ultimasLecturas' => $ultimasLecturas,
            'chartLabels' => $chartLabels,
            'pm25Data' => $pm25Data,
            'co2Data' => $co2Data
        ]);
        
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}
}