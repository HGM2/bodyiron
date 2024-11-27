@extends('layouts.app')

@section('title', 'Checklist de Asistencia')

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

        h2 {
            font-weight: bold;
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
        <h2 class="text-center text-light mb-4">Checklist de Asistencia para la Clase: {{ $clase->nombre }}</h2>

        <!-- Botón para generar reporte -->
        <div class="text-right mb-3">
            <a href="{{ route('entrenador.clases.asistencias.reporte', $clase->id) }}" class="btn btn-danger">
                Generar Reporte PDF
            </a>
        </div>

        <form action="{{ route('entrenador.clases.asistencias.update', $clase->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nombre del Cliente</th>
                            <th>Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}</td>
                                <td class="text-center">
                                    <input type="checkbox" name="attendance[{{ $cliente->id }}]" value="1" 
                                           {{ isset($asistencias[$cliente->id]) && $asistencias[$cliente->id] ? 'checked' : '' }}>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-success">Actualizar Asistencia</button>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
