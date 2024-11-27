@extends('adminlte::page')

@section('title', 'Crear Clase')

@section('content_header')
    <h1>Crear Clase</h1>
@stop

@section('content')
<div class="container mt-4">
    <form action="{{ route('admin.classes.store') }}" method="POST">
        @csrf

        <!-- Nombre de la Clase -->
        <div class="form-group">
            <label for="nombre">Nombre de la Clase</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <!-- Fecha y Hora -->
        <div class="form-group">
            <label for="fecha_hora">Fecha y Hora</label>
            <input type="datetime-local" name="fecha_hora" id="fecha_hora" class="form-control" required>
        </div>

        <!-- Entrenador Asignado -->
        <div class="form-group">
            <label for="empleado_id">Entrenador</label>
            <select name="empleado_id" id="empleado_id" class="form-control" required>
                @foreach($entrenadores as $entrenador)
                    <option value="{{ $entrenador->id }}">{{ $entrenador->nombre }} {{ $entrenador->apellido_paterno }}</option>
                @endforeach
            </select>
        </div>

        <!-- Número Máximo de Participantes -->
        <div class="form-group">
            <label for="num_max_participantes">Número Máximo de Participantes</label>
            <input type="number" name="num_max_participantes" id="num_max_participantes" class="form-control" required min="1">
        </div>

        <!-- Lugar -->
        <div class="form-group">
            <label for="lugar">Lugar</label>
            <input type="text" name="lugar" id="lugar" class="form-control" required>
        </div>

        <!-- Descripción -->
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Crear Clase</button>
    </form>
</div>
@stop
