@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <h1>Crear Usuario</h1>
@stop

@section('content')
<div class="container mt-4">
    <form action="{{ route('admin.usuarios.store') }}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" name="nombre" id="nombre" class="form-control bg-secondary text-light" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="apellido_paterno">Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control bg-secondary text-light" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="apellido_materno">Apellido Materno</label>
                        <input type="text" name="apellido_materno" id="apellido_materno" class="form-control bg-secondary text-light">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control bg-secondary text-light" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tipo de Usuario -->
        <div class="card bg-dark text-light shadow-lg mb-4">
            <div class="card-header bg-secondary">
                <h3>Tipo de Usuario</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="tipo">Tipo de Usuario</label>
                    <select name="tipo" id="tipo" class="form-control bg-secondary text-light" required>
                        <option value="admin">Administrador</option>
                        <option value="recepcionista">Recepcionista</option>
                        <option value="empleado">Empleado</option>
                        <option value="nutricionista">Nutricionista</option>
                        <option value="entrenador">Entrenador</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Foto -->
        <div class="card bg-dark text-light shadow-lg mb-4">
            <div class="card-header bg-secondary">
                <h3>Fotografía</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="foto">Seleccionar Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control-file bg-secondary text-light mb-3">
                </div>
                <div class="text-center">
                    <video id="video" class="border rounded mb-3" autoplay muted style="width: 100%; max-width: 400px;"></video>
                    <canvas id="canvas" class="d-none"></canvas>
                    <button type="button" id="captureBtn" class="btn btn-info">Capturar Foto</button>
                </div>
                <input type="hidden" name="foto_capturada" id="foto_capturada">
            </div>
        </div>

        <!-- Contraseña -->
        <div class="card bg-dark text-light shadow-lg mb-4">
            <div class="card-header bg-secondary">
                <h3>Credenciales</h3>
            </div>
            <div class="card-body">
                <div class="form-group col-md-6">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control bg-secondary text-light" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control bg-secondary text-light" required>
                </div>
            </div>
        </div>

        <!-- Botón Guardar -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Crear Usuario</button>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const captureBtn = document.getElementById('captureBtn');
    const fotoCapturada = document.getElementById('foto_capturada');

    // Inicializar la cámara
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(error => {
            console.error('No se pudo acceder a la cámara:', error);
            alert('No se pudo acceder a la cámara. Verifique los permisos.');
        });

    // Capturar foto
    captureBtn.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataURL = canvas.toDataURL('image/png');
        fotoCapturada.value = dataURL;

        alert('Foto capturada correctamente. La imagen se guardará al enviar el formulario.');
    });
</script>
@stop
