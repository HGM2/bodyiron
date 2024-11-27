<!-- resources/views/admin/classes/checklist.blade.php -->
@extends('adminlte::page')

@section('title', 'Checklist de Asistencia')

@section('content_header')
    <h1>Checklist de Asistencia para la Clase: {{ $clase->nombre }}</h1>
@stop

@section('content')
    <div class="container mt-4">
        <h4>Fecha y Hora de la Clase: {{ $clase->fecha_hora->format('d-m-Y H:i') }}</h4>
        <h5>Entrenador: {{ $clase->entrenador->nombre }}</h5>

        <form action="{{ route('admin.classes.attendance.update', $clase->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Asistió</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}</td>
                            <td>
                                <input type="checkbox" name="asistencia[{{ $cliente->id }}]" value="1" 
                                {{ in_array($cliente->id, $asistencias) ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Guardar Asistencia</button>
        </form>
    </div>
@stop
