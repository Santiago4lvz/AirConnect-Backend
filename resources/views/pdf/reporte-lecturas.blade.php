<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #4CAF50;
            margin: 0;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .info {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .estadisticas {
            margin-top: 30px;
            padding: 15px;
            background: #e8f5e9;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        .badge-bueno { color: #4CAF50; }
        .badge-regular { color: #FFC107; }
        .badge-critico { color: #F44336; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <p>Generado: {{ $fecha_generacion }}</p>
        <p>Usuario: {{ $usuario }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Total de lecturas:</strong></td>
                <td>{{ $total_lecturas }}</td>
                <td><strong>Última actualización:</strong></td>
                <td>{{ $fecha_generacion }}</td>
            </tr>
        </table>
    </div>

    @if(!empty($estadisticas))
    <div class="estadisticas">
        <h3>Estadísticas</h3>
        <table>
            <tr>
                <th>Sensor</th>
                <th>Promedio</th>
                <th>Máximo</th>
                <th>Mínimo</th>
            </tr>
            <tr>
                <td>MQ135 (Calidad Aire)</td>
                <td>{{ $estadisticas['promedios']['aire_mq135'] ?? 0 }} ppm</td>
                <td>{{ $estadisticas['maximos']['aire_mq135'] ?? 0 }} ppm</td>
                <td>{{ $estadisticas['minimos']['aire_mq135'] ?? 0 }} ppm</td>
            </tr>
            <tr>
                <td>MQ7 (CO)</td>
                <td>{{ $estadisticas['promedios']['co_mq7'] ?? 0 }} ppm</td>
                <td>{{ $estadisticas['maximos']['co_mq7'] ?? 0 }} ppm</td>
                <td>{{ $estadisticas['minimos']['co_mq7'] ?? 0 }} ppm</td>
            </tr>
            <tr>
                <td>Temperatura</td>
                <td>{{ $estadisticas['promedios']['temperatura'] ?? 0 }} °C</td>
                <td>-</td>
                <td>-</td>
            </tr>
            <tr>
                <td>Humedad</td>
                <td>{{ $estadisticas['promedios']['humedad'] ?? 0 }}%</td>
                <td>-</td>
                <td>-</td>
            </tr>
        </table>
    </div>
    @endif

    <h3>Últimas Lecturas</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>MQ135 (ppm)</th>
                <th>MQ7 (ppm)</th>
                <th>Temperatura (°C)</th>
                <th>Humedad (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lecturas as $index => $lectura)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $lectura['aire_mq135'] ?? '--' }}</td>
                <td>{{ $lectura['co_mq7'] ?? '--' }}</td>
                <td>{{ $lectura['temperatura'] ?? '--' }}</td>
                <td>{{ $lectura['humedad'] ?? '--' }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>AirConnect - Sistema de Monitoreo de Calidad del Aire</p>
        <p>Este reporte es generado automáticamente. Para más información, contacte a soporte.</p>
    </div>
</body>
</html>