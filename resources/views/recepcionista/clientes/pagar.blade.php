@extends('adminlte::page')

@section('title', 'Pagar Membresía')

@section('content_header')
    <h1 class="text-light">Pagar Membresía</h1>
@stop

@section('content')
<div class="container-fluid" style="background: url('{{ asset('images/fondo2.jpg') }}') no-repeat center center fixed; background-size: cover; padding: 2rem; border-radius: 10px;">
    <div class="card shadow-lg">
        <div class="card-body bg-dark text-light">
            <form action="{{ route('recepcion.clientes.actualizarPago', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" class="form-control bg-secondary text-light" value="{{ $cliente->nombre }} {{ $cliente->apellido_paterno }}" disabled>
                </div>

                <div class="form-group">
                    <label for="membresia_actual">Membresía Actual</label>
                    <input type="text" id="membresia_actual" class="form-control bg-secondary text-light" value="{{ $cliente->membresia->nombre ?? 'Sin membresía' }}" disabled>
                </div>

                <div class="form-group">
                    <label for="tipo_membresia">Cambiar Tipo de Membresía</label>
                    <select name="tipo_membresia" id="tipo_membresia" class="form-control bg-secondary text-light">
                        @foreach ($membresias as $membresia)
                            <option value="{{ $membresia->id }}" {{ $cliente->tipo_membresia == $membresia->id ? 'selected' : '' }}>
                                {{ $membresia->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha_registro">Nueva Fecha de Inscripción</label>
                    <input type="date" name="fecha_registro" id="fecha_registro" class="form-control bg-secondary text-light" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                </div>

                <button type="submit" class="btn btn-success">Actualizar Pago y Membresía</button>
                <a href="{{ route('recepcion.clientes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@stop
