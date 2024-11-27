@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1 class="text-light">Editar Cliente</h1>
@stop

@section('content')
<div class="container-fluid" style="background: url('{{ asset('images/fondo3.jpg') }}') no-repeat center center fixed; background-size: cover; padding: 2rem; border-radius: 10px;">
    <form action="{{ route('recepcion.clientes.update', $cliente->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Información de Membresía y Acceso -->
        <div class="card bg-dark text-light shadow-lg mb-4">
            <div class="card-header bg-secondary">
                <h3>Información de Membresía y Acceso</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="tipo_membresia">Membresía</label>
                        <select name="tipo_membresia" id="tipo_membresia" class="form-control bg-secondary text-light" required>
                            @foreach($membresias as $membresia)
                                <option value="{{ $membresia->id }}" {{ $cliente->tipo_membresia == $membresia->id ? 'selected' : '' }}
                                        data-duracion="{{ $membresia->duracion }}">
                                    {{ $membresia->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control bg-secondary text-light">
                        @if($cliente->foto)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $cliente->foto) }}" alt="Foto de {{ $cliente->nombre }}" class="img-thumbnail" width="100">
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="fecha_registro">Fecha de Inscripción</label>
                        <input type="date" name="fecha_registro" id="fecha_registro" class="form-control bg-secondary text-light" value="{{ \Carbon\Carbon::parse($cliente->fecha_registro)->format('Y-m-d') }}" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control bg-secondary text-light" value="{{ \Carbon\Carbon::parse($cliente->fecha_vencimiento)->format('Y-m-d') }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Personal -->
        <div class="card bg-dark text-light shadow-lg mb-4">
            <div class="card-header bg-secondary">
                <h3>Información Personal</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control bg-secondary text-light" value="{{ $cliente->nombre }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="apellido_paterno">Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control bg-secondary text-light" value="{{ $cliente->apellido_paterno }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="apellido_materno">Apellido Materno</label>
                        <input type="text" name="apellido_materno" id="apellido_materno" class="form-control bg-secondary text-light" value="{{ $cliente->apellido_materno }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control bg-secondary text-light" value="{{ $cliente->email }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="username">Usuario</label>
                        <input type="text" name="username" id="username" class="form-control bg-secondary text-light" value="{{ $cliente->username }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control bg-secondary text-light" value="{{ $cliente->direccion }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control bg-secondary text-light" value="{{ $cliente->telefono }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Cambio de Contraseña -->
        <div class="card bg-dark text-light shadow-lg mb-4">
            <div class="card-header bg-secondary">
                <h3>Cambiar Contraseña</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="password">Nueva Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control bg-secondary text-light">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control bg-secondary text-light">
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón Actualizar -->
        <div class="text-center">
            <button type="submit" class="btn btn-info btn-lg">Actualizar Cliente</button>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
    document.getElementById('tipo_membresia').addEventListener('change', updateFechaVencimiento);

    function updateFechaVencimiento() {
        const tipoMembresia = document.getElementById('tipo_membresia');
        const duracionMeses = parseInt(tipoMembresia.options[tipoMembresia.selectedIndex].getAttribute('data-duracion'));
        const fechaRegistro = new Date(document.getElementById('fecha_registro').value);

        if (!isNaN(duracionMeses) && fechaRegistro) {
            const fechaVencimiento = new Date(fechaRegistro);
            fechaVencimiento.setMonth(fechaVencimiento.getMonth() + duracionMeses);

            if (fechaVencimiento.getDate() !== fechaRegistro.getDate()) {
                fechaVencimiento.setDate(0);
            }

            document.getElementById('fecha_vencimiento').value = fechaVencimiento.toISOString().split('T')[0];
        }
    }
</script>
@stop
