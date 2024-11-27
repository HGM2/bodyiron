@extends('layouts.app')

@section('title', 'Horario de Clases')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos generales */
        body {
            background: url('{{ asset('images/fondo3.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            color: #f5f5f5;
        }

        .navbar {
            background-color: #c70000 !important; /* Color rojo del logo */
        }

        .navbar-brand img {
            border-radius: 50%;
        }

        .table {
            background: rgba(255, 255, 255, 0.9); /* Fondo blanco semitransparente */
            border-radius: 10px;
        }

        .thead-dark th {
            background-color: #c70000 !important; /* Encabezado rojo */
        }

        h2 {
            font-weight: bold;
        }

        footer {
            background-color: #343a40; /* Fondo oscuro para el footer */
            color: white;
            padding: 10px 0;
        }

        .btn-return {
            background-color: #c70000; /* Botón rojo */
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-return:hover {
            background-color: #900000; /* Rojo más oscuro al pasar el cursor */
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Botón de regresar -->
    <div class="container mt-3">
        <a href="http://127.0.0.1:8000/entrenador" class="btn btn-return mb-3">
            &larr; Regresar al Menú Principal
        </a>
    </div>

    <!-- Contenido principal -->
    <div class="container mt-3">
        <h2 class="text-center text-light">Horario de Clases</h2>

        @if($clases->isEmpty())
            <div class="alert alert-warning text-center mt-3">
                No hay clases asignadas.
            </div>
        @else
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre de la Clase</th>
                            <th>Fecha y Hora</th>
                            <th>Máx. Participantes</th>
                            <th>Instructor</th>
                            <th>Descripción</th>
                            <th>Lugar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clases as $clase)
                            <tr>
                                <td>{{ $clase->nombre }}</td>
                                <td>{{ \Carbon\Carbon::parse($clase->fecha_hora)->format('d/m/Y H:i') }}</td>
                                <td>{{ $clase->num_max_participantes }}</td>
                                <td>{{ $clase->instructor ? $clase->instructor->nombre : 'No asignado' }}</td>
                                <td>{{ $clase->descripcion }}</td>
                                <td>{{ $clase->lugar }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
