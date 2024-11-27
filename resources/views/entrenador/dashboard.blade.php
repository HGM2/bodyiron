<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Entrenador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Personalización de colores */
        body {
            background: url('images/fondo7.jpg') no-repeat center center fixed; /* Imagen de fondo */
            background-size: cover;
            color: #f5f5f5; /* Texto claro */
        }
        .navbar {
            background-color: #c70000 !important; /* Rojo del logo */
        }
        .navbar-brand img {
            border-radius: 50%; /* Hacer el logo redondo */
        }
        .btn-primary {
            background-color: #c70000 !important; /* Rojo del logo */
            border-color: #c70000 !important;
        }
        .btn-primary:hover {
            background-color: #900000 !important; /* Rojo más oscuro */
            border-color: #900000 !important;
        }
        .list-group-item {
            border: none;
            border-radius: 10px;
        }
        .list-group-item.bg-dark {
            background-color: rgba(0, 0, 0, 0.8); /* Fondo oscuro transparente */
        }
        .list-group-item a {
            font-weight: bold;
        }
        .text-highlight {
            color: #c70000; /* Resaltar en rojo */
        }
        h2, h4 {
            font-weight: bold;
        }
        /* Reloj */
        #clock {
            font-size: 1.5rem;
            font-weight: bold;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
            border-radius: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/gym-logo.png') }}" alt="Gym Logo" width="40" height="40" class="mr-2">
                <span>Body Iron Fitness</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container text-center py-5">
        <!-- Logo y Bienvenida -->
        <img src="{{ asset('images/gym-logo.png') }}" alt="Gym Logo" width="120" class="mb-4">
        <h2 class="mb-4">Bienvenido, <span class="text-highlight">Entrenador</span> de Body Iron Fitness</h2>

        <!-- Reloj -->
        <div id="clock" class="mb-4"></div>

        <!-- Botón para Ver Clases -->
        <a href="{{ route('entrenador.clases.index') }}" class="btn btn-primary btn-lg mb-4">Ver Información de Clases</a>

        <!-- Lista de Clases -->
        <div class="mt-4">
            <h4 class="text-highlight mb-3">Clases Asignadas</h4>
            <ul class="list-group">
                @foreach($clases as $clase)
                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                        <span>
                            <strong>{{ $clase->nombre }}</strong> - {{ \Carbon\Carbon::parse($clase->fecha_hora)->format('d/m/Y H:i') }}
                        </span>
                        <a href="{{ route('entrenador.clases.asistencias', ['class' => $clase->id]) }}" class="btn btn-primary btn-sm">Checklist de Asistencia</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

        <!-- Footer -->
        <footer class="text-center mt-5">
            <p>&copy; 2024 Body Iron Fitness - Todos los derechos reservados</p>
        </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Actualiza el reloj cada segundo
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const date = now.toLocaleDateString('es-ES', options);
            document.getElementById('clock').innerHTML = `${date} - ${time}`;
        }
        setInterval(updateClock, 1000);
        updateClock(); // Llama la función inmediatamente al cargar la página
    </script>
</body>
</html>
