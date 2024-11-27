@extends('adminlte::page')

@section('title', 'Editar Membresía')

@section('content_header')
    <h1>Editar Membresía</h1>
@stop

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.memberships.update', $membresia->id) }}">
                @csrf
                @method('PUT')

                <!-- Nombre -->
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $membresia->nombre) }}" required>
                    @error('nombre')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $membresia->descripcion) }}</textarea>
                    @error('descripcion')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Precio -->
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" name="precio" id="precio" class="form-control" value="{{ old('precio', $membresia->precio) }}" required min="0" step="0.01">
                    @error('precio')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Duración en Meses -->
                <div class="form-group">
                    <label for="duracion">Duración (meses)</label>
                    <input type="number" name="duracion" id="duracion" class="form-control" value="{{ old('duracion', $membresia->duracion) }}" required min="1">
                    @error('duracion')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Actualizar Membresía</button>
            </form>
        </div>
    </div>
</div>
@stop