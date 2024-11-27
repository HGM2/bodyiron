<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Mensual de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            background-color: #c70000;
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .section-title {
            margin: 30px 0 15px;
            font-size: 18px;
            font-weight: bold;
            color: #c70000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #c70000;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td[colspan="4"] {
            text-align: center;
            font-style: italic;
            color: #666;
        }

        .no-data {
            text-align: center;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Body Iron Fitness</h1>
        <p>{{ $gymData['direccion'] }}</p>
        <p>Teléfono: {{ $gymData['telefono'] }} | Email: {{ $gymData['email'] }}</p>
        <p>Fecha del reporte: {{ $hoy->format('d/m/Y') }}</p>
    </div>

    <div>
        <h2 class="section-title">Clientes Vigentes</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Vencimiento</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vigentes as $cliente)
                    <tr>
                        <td>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ \Carbon\Carbon::parse($cliente->fecha_vencimiento)->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="no-data">No hay clientes vigentes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        <h2 class="section-title">Clientes a 5 Días de Vencer</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Vencimiento</th>
                </tr>
            </thead>
            <tbody>
                @forelse($a_vencer as $cliente)
                    <tr>
                        <td>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ \Carbon\Carbon::parse($cliente->fecha_vencimiento)->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="no-data">No hay clientes a punto de vencer.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        <h2 class="section-title">Clientes Vencidos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Vencimiento</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vencidos as $cliente)
                    <tr>
                        <td>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}</td>
                        <td>{{ $cliente->email }}</td>
                        <td>{{ $cliente->telefono }}</td>
                        <td>{{ \Carbon\Carbon::parse($cliente->fecha_vencimiento)->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="no-data">No hay clientes vencidos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
