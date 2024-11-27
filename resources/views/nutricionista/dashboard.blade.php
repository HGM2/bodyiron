<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Nutricionista</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('{{ asset('images/fondo6.jpg') }}') no-repeat center center fixed;
            background-size: cover;
            color: #f5f5f5;
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background-color: #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand img {
            border-radius: 50%;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.3);
        }

        .card {
            border: none;
            border-radius: 15px;
            background: rgba(0, 0, 0, 0.85);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            color: #fff;
        }

        .card-header {
            background-color: #444;
            border-bottom: 2px solid #555;
            font-size: 1.25rem;
            font-weight: bold;
            text-align: center;
        }

        .btn {
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 25px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #444, #666);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #666, #444);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }

        .btn-secondary {
            background-color: #555;
            color: #fff;
            border: 1px solid #666;
        }

        .btn-secondary:hover {
            background-color: #444;
            color: #eaeaea;
            border: 1px solid #888;
        }

        .list-group-item {
            background-color: rgba(0, 0, 0, 0.8);
            border: 1px solid #555;
            border-radius: 10px;
            margin-bottom: 10px;
            color: #f5f5f5;
        }

        h2, h4 {
            font-weight: bold;
        }

        .text-highlight {
            color: #a10909fb;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #ccc;
            font-size: 0.9rem;
        }

        .footer a {
            color: #ff7e5f;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('nutricionista.dashboard') }}">
                <img src="{{ asset('images/gym-logo.png') }}" alt="Gym Logo" width="50" height="50" class="mr-2">
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

    <!-- Contenido principal -->
    <div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
        <!-- Bienvenida -->
        <div class="card w-100 mb-4">
            <div class="card-header">
                <img src="{{ asset('images/gym-logo.png') }}" alt="Gym Logo" width="100" class="mb-3">
                <h2>Bienvenido, <span class="text-highlight">Nutricionista</span></h2>
            </div>
            <div class="card-body text-center">
                <a href="{{ route('nutricionista.citas.index') }}" class="btn btn-primary btn-lg mr-3">Ver Citas Programadas</a>
                <a href="{{ route('nutricionista.disponibilidad.form') }}" class="btn btn-primary btn-lg">Actualizar Disponibilidad</a>
            </div>
        </div>

        <!-- Lista de citas -->
        <div class="card w-100">
            <div class="card-header">
                <h4 class="text-highlight">Citas Programadas:</h4>
            </div>
            <div class="card-body">
                @if($citas->isEmpty())
                    <p class="text-center">No tienes citas programadas.</p>
                @else
                    <ul class="list-group">
                        @foreach($citas as $cita)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    @if($cita->cliente)
                                        <strong>{{ $cita->cliente->nombre }}</strong> - {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }}
                                    @else
                                        <strong>Sin asignar</strong> - {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }}
                                    @endif
                                </span>
                                <form action="{{ route('nutricionista.citas.addNotes', ['appointmentId' => $cita->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Agregar Notas</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="card-footer text-center">
                <!-- Botón para Generar Reporte (PDF) -->
                <form action="{{ route('nutricionista.generateReport') }}" method="GET" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-lg">Generar Reporte (PDF)</button>
                </form>
            </div>
            
            <div class="card-footer text-center">
                <!-- Botón para Generar Reporte con Gráfico (Excel) -->
                <form action="{{ route('nutricionista.generateExcel') }}" method="GET" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-lg">Generar Reporte con Gráfico (Excel)</button>
                </form>
            </div>
            
        </div>
        
            <div class="card-footer text-center">
                <p class="footer">&copy; 2024 Body Iron Fitness - <a href="#">Términos y Condiciones</a></p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
