<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Asistencia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        h1, h2 {
            color: #c70000;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Reporte de Asistencia</h1>
    <h2>Clase: {{ $clase->nombre }}</h2>
    <p><strong>Fecha y Hora:</strong> {{ $clase->fecha_hora }}</p>

    <h3>Clientes que Asistieron</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asistieron as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Clientes que No Asistieron</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($noAsistieron as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
