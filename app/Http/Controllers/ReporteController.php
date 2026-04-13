<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteController extends Controller
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
     * Generar reporte PDF de todas las lecturas
     * GET /api/reporte/lecturas
     */
    public function reporteLecturas(Request $request)
    {
        $lecturas = $this->getFirebaseData();
        
        if (!$lecturas) {
            return response()->json(['error' => 'No hay datos'], 404);
        }

        // Obtener usuario autenticado (si existe)
        $user = null;
        $token = $request->bearerToken();
        if ($token) {
            $hashedToken = hash('sha256', $token);
            $user = User::where('remember_token', $hashedToken)->first();
        }

        // Preparar datos para el PDF
        $data = [
            'titulo' => 'Reporte de Calidad del Aire - AirConnect',
            'fecha_generacion' => now()->format('d/m/Y H:i:s'),
            'total_lecturas' => count($lecturas),
            'ultima_lectura' => end($lecturas),
            'lecturas' => array_slice($lecturas, -50), // Últimas 50 lecturas
            'usuario' => $user ? $user->name : 'Visitante',
            'estadisticas' => $this->calcularEstadisticas($lecturas)
        ];

        // Generar PDF
        $pdf = Pdf::loadView('pdf.reporte-lecturas', $data);
        
        // Descargar o mostrar
        return $pdf->download('reporte_airconnect_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Generar reporte PDF por rango de fechas
     * POST /api/reporte/rango
     */
    public function reportePorRango(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $lecturas = $this->getFirebaseData();
        
        if (!$lecturas) {
            return response()->json(['error' => 'No hay datos'], 404);
        }

        // Filtrar por rango (simplificado - ajusta según tu estructura)
        $lecturasFiltradas = array_filter($lecturas, function($lectura) use ($request) {
            // Si tienes timestamp en tus lecturas, filtra aquí
            return true; // Por ahora devuelve todas
        });

        $data = [
            'titulo' => 'Reporte de Calidad del Aire - AirConnect',
            'subtitulo' => "Periodo: {$request->fecha_inicio} al {$request->fecha_fin}",
            'fecha_generacion' => now()->format('d/m/Y H:i:s'),
            'total_lecturas' => count($lecturasFiltradas),
            'lecturas' => array_slice($lecturasFiltradas, -50),
            'estadisticas' => $this->calcularEstadisticas($lecturasFiltradas)
        ];

        $pdf = Pdf::loadView('pdf.reporte-rango', $data);
        return $pdf->download('reporte_rango_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Calcular estadísticas
     */
    private function calcularEstadisticas($lecturas)
    {
        if (empty($lecturas)) {
            return [];
        }

        $sumas = ['aire_mq135' => 0, 'co_mq7' => 0, 'gas_mq2' => 0, 'temperatura' => 0, 'humedad' => 0];
        $maximos = ['aire_mq135' => 0, 'co_mq7' => 0, 'gas_mq2' => 0];
        $minimos = ['aire_mq135' => PHP_FLOAT_MAX, 'co_mq7' => PHP_FLOAT_MAX, 'gas_mq2' => PHP_FLOAT_MAX];

        foreach ($lecturas as $lectura) {
            foreach ($sumas as $key => $value) {
                if (isset($lectura[$key])) {
                    $sumas[$key] += $lectura[$key];
                    
                    if (isset($maximos[$key]) && $lectura[$key] > $maximos[$key]) {
                        $maximos[$key] = $lectura[$key];
                    }
                    if (isset($minimos[$key]) && $lectura[$key] < $minimos[$key]) {
                        $minimos[$key] = $lectura[$key];
                    }
                }
            }
        }

        $count = count($lecturas);
        return [
            'promedios' => [
                'aire_mq135' => round($sumas['aire_mq135'] / $count, 2),
                'co_mq7' => round($sumas['co_mq7'] / $count, 2),
                'gas_mq2' => round($sumas['gas_mq2'] / $count, 2),
                'temperatura' => round($sumas['temperatura'] / $count, 2),
                'humedad' => round($sumas['humedad'] / $count, 2),
            ],
            'maximos' => $maximos,
            'minimos' => $minimos,
            'total_lecturas' => $count
        ];
    }
}