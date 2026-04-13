<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $firebaseUrl = 'https://airconnect-f6bdc-default-rtdb.firebaseio.com/lecturas.json';

    /**
     * Obtener datos de Firebase
     */
    private function getFirebaseData()
    {
        try {
            $json = file_get_contents($this->firebaseUrl);
            $lecturas = json_decode($json, true);
            
            if (!$lecturas || !is_array($lecturas)) {
                return null;
            }
            
            return array_values($lecturas);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * =============================================
     * MÉTODO PARA VISTA WEB (Dashboard Blade)
     * =============================================
     */

    public function index()
    {
        $lecturas = $this->getFirebaseData();

        if (!$lecturas) {
            return view('dashboard', [
                'ultima' => [],
                'ultimasLecturas' => [],
                'chartLabels' => [],
                'pm25Data' => [],
                'co2Data' => []
            ])->with('error', 'No se pudieron cargar las lecturas de Firebase');
        }

        // Última lectura
        $ultima = end($lecturas);

        // Últimas 10 lecturas
        $ultimasLecturas = array_slice($lecturas, -10);

        // Datos para gráfica
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
    }

    /**
     * =============================================
     * MÉTODOS PARA API (Ionic / Frontend)
     * =============================================
     */

    /**
     * API: Obtener todas las lecturas (últimas 20)
     * GET /api/lecturas
     */
    public function apiGetLecturas()
    {
        $lecturas = $this->getFirebaseData();

        if (!$lecturas) {
            return response()->json([
                'success' => false,
                'message' => 'No hay datos disponibles',
                'data' => []
            ], 404);
        }

        // Obtener últimas 20 lecturas
        $ultimasLecturas = array_slice($lecturas, -20);

        return response()->json([
            'success' => true,
            'data' => $ultimasLecturas,
            'total' => count($lecturas),
            'timestamp' => now()
        ]);
    }

    /**
     * API: Obtener solo la última lectura
     * GET /api/lecturas/ultima
     */
    public function apiGetUltimaLectura()
    {
        $lecturas = $this->getFirebaseData();

        if (!$lecturas) {
            return response()->json([
                'success' => false,
                'message' => 'No hay datos disponibles'
            ], 404);
        }

        $ultima = end($lecturas);

        return response()->json([
            'success' => true,
            'data' => $ultima,
            'timestamp' => now()
        ]);
    }

    /**
     * API: Obtener lecturas recientes (últimas N)
     * GET /api/lecturas/recientes/{limit?}
     */
    public function apiGetLecturasRecientes($limit = 10)
    {
        $lecturas = $this->getFirebaseData();

        if (!$lecturas) {
            return response()->json([
                'success' => false,
                'message' => 'No hay datos disponibles',
                'data' => []
            ], 404);
        }

        // Limitar entre 1 y 50
        $limit = max(1, min(50, (int)$limit));
        
        // Obtener últimas N lecturas
        $recientes = array_slice($lecturas, -$limit);

        // Generar datos para gráfica
        $chartLabels = [];
        $mq135Data = [];
        $mq7Data = [];

        foreach ($recientes as $index => $lectura) {
            $chartLabels[] = ($index + 1);
            $mq135Data[] = $lectura['aire_mq135'] ?? 0;
            $mq7Data[] = $lectura['co_mq7'] ?? 0;
        }

        return response()->json([
            'success' => true,
            'data' => $recientes,
            'charts' => [
                'labels' => $chartLabels,
                'mq135' => $mq135Data,
                'mq7' => $mq7Data
            ],
            'total' => count($lecturas),
            'limit' => $limit,
            'timestamp' => now()
        ]);
    }

    /**
     * =============================================
     * MÉTODOS LEGACY (para compatibilidad)
     * =============================================
     */

    public function getUltimasLecturas()
    {
        return $this->apiGetUltimaLectura();
    }

    public function checkin(Request $request)
    {
        return redirect()->back()->with('success', 'Checkin realizado');
    }

    public function checkout(Request $request)
    {
        return redirect()->back()->with('success', 'Checkout realizado');
    }
}