@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario</h1>
@stop

@section('content')
<div class="container mt-4">
    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
        </div>

        <div class="form-group">
            <label for="apellido_paterno">Apellido Paterno</label>
            <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" value="{{ $usuario->apellido_paterno }}" required>
        </div>

        <div class="form-group">
            <label for="apellido_materno">Apellido Materno</label>
            <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" value="{{ $usuario->apellido_materno }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $usuario->email }}" required>
        </div>

        <div class="form-group">
            <label for="tipo">Tipo de Usuario</label>
            <select name="tipo" id="tipo" class="form-control" required>
                <option value="admin" {{ $usuario->tipo == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="usuario" {{ $usuario->tipo == 'usuario' ? 'selected' : '' }}>Usuario</option>
            </select>
        </div>

        <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control-file">
            @if($usuario->foto)
                <img src="{{ asset('storage/' . $usuario->foto) }}" alt="Foto de {{ $usuario->nombre }}" width="100">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
@stop
