@extends('layouts.app')

@section('title', 'Citas Programadas')

@section('content')
<body style="background: url('{{ asset('images/fondo6.jpg') }}') no-repeat center center fixed; background-size: cover; color: #f5f5f5;">
    <div class="container mt-5">
        <!-- Encabezado -->
        <div class="card shadow-lg border-0" style="background-color: rgba(0, 0, 0, 0.8); border-radius: 20px;">
            <div class="card-header d-flex justify-content-between align-items-center text-white fw-bold" style="background-color: rgba(0, 0, 0, 0.9); border-radius: 20px 20px 0 0;">
                <h2 class="mb-0"><i class="fas fa-calendar-alt"></i> Citas Programadas</h2>
                <a href="{{ route('nutricionista.dashboard') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>
            <div class="card-body">
                <!-- Mensajes de éxito y error -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
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

                <!-- Formulario de asistencia -->
                <form action="{{ route('nutricionista.citas.bulkRegisterAttendance') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-dark table-hover table-striped">
                            <thead class="thead-dark text-uppercase">
                                <tr>
                                    <th class="text-center">Asistencia</th>
                                    <th>Fecha y Hora</th>
                                    <th>Cliente</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($citas as $cita)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="asistencias[]" value="{{ $cita->id }}" 
                                                   {{ $cita->asistio ? 'checked' : '' }} class="form-check-input">
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($cita->cliente)
                                                {{ $cita->cliente->nombre }} {{ $cita->cliente->apellido_paterno }}
                                            @else
                                                <span class="text-muted">Sin asignar</span>
                                            @endif
                                        </td>
                                        <td>{{ $cita->descripcion ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-light">No hay citas programadas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Guardar Asistencias
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
    .form-check-input {
        transform: scale(1.2);
    }

    .form-check-input:checked {
        background-color: #c70000;
        border-color: #c70000;
    }

    .table {
        color: #f5f5f5;
        border-radius: 10px;
        overflow: hidden;
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

    .card {
        border: none;
    }

    .card-header {
        font-size: 1.5rem;
        background-color: rgba(0, 0, 0, 0.85);
    }
</style>
@endpush
