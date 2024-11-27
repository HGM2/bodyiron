@extends('layouts.app')

@section('title', 'Actualizar Disponibilidad')

@section('content')
<body style="background: url('{{ asset('images/fondo3.jpg') }}') no-repeat center center fixed; background-size: cover; color: #f5f5f5;">
    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="card shadow-lg border-0" style="background-color: rgba(0, 0, 0, 0.8); border-radius: 20px;">
            <div class="card-header d-flex justify-content-between align-items-center text-white fw-bold" style="background-color: rgba(0, 0, 0, 0.9); border-radius: 20px 20px 0 0;">
                <h2 class="mb-0"><i class="fas fa-calendar-check"></i> Actualizar Disponibilidad</h2>
                <a href="{{ route('nutricionista.dashboard') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
            <div class="card-body">
                <!-- Mensaje de éxito -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Mensajes de error -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> Por favor corrige los siguientes errores:
                        <ul class="mt-2 mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Formulario -->
                <form action="{{ route('nutricionista.disponibilidad.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="fecha_disponible" class="form-label fw-bold text-light">Fecha Disponible</label>
                        <input type="date" name="fecha_disponible" id="fecha_disponible" class="form-control bg-dark text-white" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="hora_inicio" class="form-label fw-bold text-light">Hora de Inicio</label>
                            <input type="time" name="hora_inicio" id="hora_inicio" class="form-control bg-dark text-white" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hora_fin" class="form-label fw-bold text-light">Hora de Fin</label>
                            <input type="time" name="hora_fin" id="hora_fin" class="form-control bg-dark text-white" required>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Disponibilidad
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection

@push('styles')
<style>
    .form-control {
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .form-control:focus {
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .btn-primary {
        background: linear-gradient(90deg, #c70000, #900000);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, #900000, #c70000);
        box-shadow: 0 4px 15px rgba(255, 0, 0, 0.5);
    }

    .btn-secondary {
        background: #343a40;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background: #23272b;
        color: #fff;
    }
</style>
@endpush
