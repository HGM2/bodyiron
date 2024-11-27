<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Body Iron Fitness') }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Colores principales */
        .navbar {
            background-color: #c70000 !important; /* Rojo del logo */
        }
        .navbar-brand img {
            border-radius: 50%; /* Logo redondo */
        }
        footer {
            background-color: #343a40; /* Fondo oscuro */
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="min-vh-100 d-flex flex-column">
        <!-- Barra de navegación -->
        @include('layouts.navigation')

        <!-- Contenido principal -->
        <main class="flex-fill py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="text-center py-3">
            <small>© {{ date('Y') }} Body Iron Fitness - Todos los derechos reservados</small>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
