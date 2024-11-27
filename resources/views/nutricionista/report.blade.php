<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Citas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1, h2 {
            text-align: center;
            color: #c70000;
            margin-bottom: 10px;
        }
        .summary {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        .summary p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        table thead {
            background-color: #c70000;
            color: #fff;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            font-size: 1rem;
        }
        tbody tr:nth-child(even) {
            background-color: #f4f4f4;
        }
        tbody tr:hover {
            background-color: #f1e5e5;
        }
        .status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status.asistio {
            background-color: #28a745;
            color: #fff;
        }
        .status.no-asistio {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Reporte de Citas</h1>
    <h2>{{ date('d/m/Y') }}</h2>

    <div class="summary">
        <p><strong>Total de citas:</strong> {{ $reporte['total'] }}</p>
        <p><strong>Asistieron:</strong> {{ $reporte['asistieron'] }}</p>
        <p><strong>No asistieron:</strong> {{ $reporte['no_asistieron'] }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Cliente</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }}</td>
                    <td>{{ $cita->cliente->nombre ?? 'Sin asignar' }}</td>
                    <td>
                        <span class="status {{ $cita->asistio ? 'asistio' : 'no-asistio' }}">
                            {{ $cita->asistio ? 'Asistió' : 'No asistió' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
