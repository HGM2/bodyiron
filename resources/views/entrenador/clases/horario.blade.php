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
            background: url('{{ asset('images/fondo4.jpg') }}') no-repeat center center fixed;
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

        h1 {
            font-weight: bold;
            color: white;
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

        footer {
            background-color: #343a40; /* Fondo oscuro para el footer */
            color: white;
            padding: 10px 0;
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
        <h1 class="text-center">Horario de Clases</h1>

        <div class="card mt-4">
            <div class="card-body">
                @if($clases->isEmpty())
                    <div class="alert alert-warning text-center">
                        No hay clases asignadas.
                    </div>
                @else
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Clase</th>
                                <th>Fecha y Hora</th>
                                <th>Ubicación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clases as $clase)
                                <tr>
                                    <td>{{ $clase->nombre }}</td>
                                    <td>{{ \Carbon\Carbon::parse($clase->fecha_hora)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $clase->ubicacion ?? 'No especificada' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5">
        <p>&copy; 2024 Body Iron Fitness - Todos los derechos reservados</p>
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
