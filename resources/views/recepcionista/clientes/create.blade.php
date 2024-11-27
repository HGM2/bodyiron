@extends('adminlte::page')

@section('title', 'Agregar Cliente')

@section('content_header')
    <h1 class="text-light">Agregar Cliente</h1>
@stop

@section('content')
<div class="container-fluid" style="background: url('{{ asset('images/fondo5.jpg') }}') no-repeat center center fixed; background-size: cover; padding: 2rem; border-radius: 10px;">
    <form action="{{ route('recepcion.clientes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Información Personal -->
        <div class="card bg-dark text-light shadow-lg mb-4">
            <div class="card-header bg-secondary">
                <h3>Información Personal</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control bg-secondary text-light" placeholder="Ejemplo: Juan" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="apellido_paterno">Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" class="form-control bg-secondary text-light" placeholder="Ejemplo: Pérez" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="apellido_materno">Apellido Materno</label>
                        <input type="text" name="apellido_materno" class="form-control bg-secondary text-light" placeholder="Ejemplo: Gómez">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control bg-secondary text-light" placeholder="Ejemplo: correo@ejemplo.com" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" class="form-control bg-secondary text-light" placeholder="Ejemplo: 1234567890">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" class="form-control bg-secondary text-light" placeholder="Ejemplo: Calle Falsa 123">
                    </div>
                </div>
            </div>
        </div>

        <!-- Captura o Selección de Fotografía -->
        <div class="card bg-dark text-light shadow-lg mb-4">
            <div class="card-header bg-secondary">
                <h3>Fotografía del Cliente</h3>
            </div>
            <div class="card-body text-center">
                <video id="video" class="border rounded" autoplay muted style="width: 100%; max-width: 400px;"></video>
                <canvas id="canvas" class="d-none"></canvas>
                <button type="button" id="captureBtn" class="btn btn-info mt-3">Capturar Foto</button>
                <input type="hidden" name="foto_capturada" id="foto_capturada">

                <p class="mt-3 text-muted">O selecciona una imagen desde tu dispositivo:</p>
                <input type="file" name="foto_subida" class="form-control-file bg-secondary text-light" accept="image/*">
            </div>
        </div>

        <!-- Información de Membresía y Acceso -->
        <div class="card bg-dark text-light shadow-lg mb-4">
            <div class="card-header bg-secondary">
                <h3>Información de Membresía y Acceso</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="username">Nombre de Usuario</label>
                        <input type="text" name="username" class="form-control bg-secondary text-light" placeholder="Ejemplo: juanperez" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" class="form-control bg-secondary text-light" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control bg-secondary text-light" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tipo_membresia">Tipo de Membresía</label>
                        <select name="tipo_membresia" id="tipo_membresia" class="form-control bg-secondary text-light" required>
                            <option value="" disabled selected>Seleccione una membresía</option>
                            @foreach($membresias as $membresia)
                                <option value="{{ $membresia->id }}" data-duracion="{{ $membresia->duracion }}">
                                    {{ $membresia->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha_registro">Fecha de Inscripción</label>
                        <input type="date" name="fecha_registro" id="fecha_registro" class="form-control bg-secondary text-light" required value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control bg-secondary text-light" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de Guardar -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Guardar Cliente</button>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
    // Lógica de cámara y captura de imagen
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('captureBtn');
    const fotoCapturada = document.getElementById('foto_capturada');

    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => { video.srcObject = stream; })
        .catch(err => { alert('Error accediendo a la cámara: ' + err.message); });

    captureBtn.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        fotoCapturada.value = canvas.toDataURL('image/png');
        alert('Foto capturada.');
    });

    // Actualización de fecha de vencimiento
    document.getElementById('tipo_membresia').addEventListener('change', updateFechaVencimiento);
    document.getElementById('fecha_registro').addEventListener('change', updateFechaVencimiento);

    function updateFechaVencimiento() {
        const tipoMembresia = document.getElementById('tipo_membresia');
        const duracionMeses = parseInt(tipoMembresia.options[tipoMembresia.selectedIndex].getAttribute('data-duracion'));
        const fechaRegistro = new Date(document.getElementById('fecha_registro').value);
        if (!isNaN(duracionMeses) && fechaRegistro) {
            fechaRegistro.setMonth(fechaRegistro.getMonth() + duracionMeses);
            document.getElementById('fecha_vencimiento').value = fechaRegistro.toISOString().split('T')[0];
        }
    }
</script>
@stop
