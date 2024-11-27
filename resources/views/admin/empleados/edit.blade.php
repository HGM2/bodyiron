@extends('adminlte::page')

@section('title', 'Editar Empleado')

@section('content_header')
    <h1 class="text-light text-center">Editar Empleado</h1>
@stop

@section('content')
<div class="container-fluid" style="background: url('{{ asset('images/fondo6.jpg') }}') no-repeat center center fixed; background-size: cover; padding: 2rem; border-radius: 10px;">
    <form action="{{ route('admin.empleados.update', $empleado->id) }}" method="POST" enctype="multipart/form-data" class="bg-dark text-light p-4 shadow-lg rounded">
        @csrf
        @method('PUT')

        <!-- Información Personal -->
        <div class="card bg-secondary text-light shadow mb-4">
            <div class="card-header">
                <h3>Información Personal</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control bg-dark text-light" value="{{ $empleado->nombre }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="apellido_paterno">Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control bg-dark text-light" value="{{ $empleado->apellido_paterno }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="apellido_materno">Apellido Materno</label>
                        <input type="text" name="apellido_materno" id="apellido_materno" class="form-control bg-dark text-light" value="{{ $empleado->apellido_materno }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control bg-dark text-light" value="{{ $empleado->email }}" required>
                    </div>
                </div>
            </div>
        </div>

<!-- Detalles del Puesto -->
<div class="card bg-secondary text-light shadow mb-4">
    <div class="card-header">
        <h3>Detalles del Puesto</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="puesto">Puesto</label>
                <select name="puesto" id="puesto" class="form-control bg-dark text-light" required>
                    <option value="entrenador" {{ $empleado->puesto == 'entrenador' ? 'selected' : '' }}>Entrenador</option>
                    <option value="nutricionista" {{ $empleado->puesto == 'nutricionista' ? 'selected' : '' }}>Nutricionista</option>
                    <option value="recepcionista" {{ $empleado->puesto == 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                    <option value="mantenimiento" {{ $empleado->puesto == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                    <option value="limpieza" {{ $empleado->puesto == 'limpieza' ? 'selected' : '' }}>Limpieza</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="salario_hora">Salario por Hora</label>
                <input type="number" name="salario_hora" id="salario_hora" class="form-control bg-dark text-light" value="{{ $empleado->salario_hora }}" required step="0.01" min="0">
            </div>
            <div class="form-group col-md-12">
                <label for="experiencia">Experiencia</label>
                <textarea name="experiencia" id="experiencia" class="form-control bg-dark text-light">{{ $empleado->experiencia }}</textarea>
            </div>
        </div>
    </div>
</div>


        <!-- Foto -->
        <div class="card bg-secondary text-light shadow mb-4">
            <div class="card-header">
                <h3>Fotografía</h3>
            </div>
            <div class="card-body text-center">
                <div class="text-center mb-3">
                    @if($empleado->foto)
                        <img src="{{ asset('storage/' . $empleado->foto) }}" alt="Foto de {{ $empleado->nombre }}" class="img-thumbnail mb-3" width="100">
                    @else
                        <span class="text-muted">Sin foto</span>
                    @endif
                </div>
                <label for="foto" class="form-label">Actualizar Foto</label>
                <input type="file" name="foto" id="foto" class="form-control bg-dark text-light">
            </div>
        </div>

        <!-- Fecha de Contratación -->
        <div class="card bg-secondary text-light shadow mb-4">
            <div class="card-header">
                <h3>Fecha de Contratación</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="fecha_contratacion">Fecha de Contratación</label>
                    <input type="date" name="fecha_contratacion" id="fecha_contratacion" class="form-control bg-dark text-light" value="{{ $empleado->fecha_contratacion ? \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('Y-m-d') : '' }}" required>
                </div>
            </div>
        </div>

        <!-- Botón de Guardar -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Actualizar Empleado</button>
        </div>
    </form>
</div>
@stop
