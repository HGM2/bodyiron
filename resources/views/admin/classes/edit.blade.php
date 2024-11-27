@extends('adminlte::page')

@section('title', 'Editar Clase')

@section('content_header')
    <h1>Editar Clase</h1>
@stop

@section('content')
<div class="container mt-4">
    <form action="{{ route('admin.classes.update', $clase->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nombre de la Clase -->
        <div class="form-group">
            <label for="nombre">Nombre de la Clase</label>
            <input type="text" name="nombre" class="form-control" id="nombre" value="{{ $clase->nombre }}" required>
        </div>

        <!-- Fecha y Hora -->
        <div class="form-group">
            <label for="fecha_hora">Fecha y Hora</label>
            <input type="datetime-local" name="fecha_hora" class="form-control" id="fecha_hora" 
                   value="{{ \Carbon\Carbon::parse($clase->fecha_hora)->format('Y-m-d\TH:i') }}" required>
        </div>

        <!-- Entrenador Asignado -->
        <div class="form-group">
            <label for="empleado_id">Entrenador</label>
            <select name="empleado_id" class="form-control" id="empleado_id" required>
                @foreach($entrenadores as $entrenador)
                    <option value="{{ $entrenador->id }}" {{ $entrenador->id == $clase->empleado_id ? 'selected' : '' }}>
                        {{ $entrenador->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Número Máximo de Participantes -->
        <div class="form-group">
            <label for="num_max_participantes">Número Máximo de Participantes</label>
            <input type="number" name="num_max_participantes" class="form-control" id="num_max_participantes" 
                   value="{{ $clase->num_max_participantes }}" required min="1">
        </div>

        <!-- Lugar -->
        <div class="form-group">
            <label for="lugar">Lugar</label>
            <input type="text" name="lugar" class="form-control" id="lugar" value="{{ $clase->lugar }}" required>
        </div>

        <!-- Descripción -->
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" class="form-control" id="descripcion" rows="3">{{ $clase->descripcion }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Clase</button>
    </form>
</div>
@stop
