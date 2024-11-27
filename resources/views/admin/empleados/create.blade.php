@extends('adminlte::page')

@section('title', 'Agregar Empleado')

@section('content_header')
    <h1 class="text-light">Agregar Empleado</h1>
@stop

@section('content')
<div class="container-fluid" style="background: url('{{ asset('images/fondo6.jpg') }}') no-repeat center center fixed; background-size: cover; padding: 2rem; border-radius: 10px;">
    <form action="{{ route('admin.empleados.store') }}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" name="nombre" id="nombre" class="form-control bg-secondary text-light" placeholder="Ejemplo: Juan" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="apellido_paterno">Apellido Paterno</label>
                        <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control bg-secondary text-light" placeholder="Ejemplo: Pérez" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="apellido_materno">Apellido Materno</label>
                        <input type="text" name="apellido_materno" id="apellido_materno" class="form-control bg-secondary text-light" placeholder="Ejemplo: Gómez">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control bg-secondary text-light" placeholder="Ejemplo: correo@ejemplo.com" required>
                    </div>
                </div>
            </div>
        </div>
<!-- Detalles del Empleo -->
<div class="card bg-dark text-light shadow-lg mb-4">
    <div class="card-header bg-secondary">
        <h3>Detalles del Empleo</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="puesto">Puesto</label>
                <select name="puesto" id="puesto" class="form-control bg-secondary text-light" required>
                    <option value="entrenador">Entrenador</option>
                    <option value="nutricionista">Nutricionista</option>
                    <option value="recepcionista">Recepcionista</option>
                    <option value="mantenimiento">Mantenimiento</option>
                    <option value="limpieza">Limpieza</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="salario_hora">Salario por Hora</label>
                <input type="number" name="salario_hora" id="salario_hora" class="form-control bg-secondary text-light" placeholder="Ejemplo: 50.00" required step="0.01" min="0">
            </div>
            <div class="form-group col-md-12">
                <label for="experiencia">Experiencia</label>
                <textarea name="experiencia" id="experiencia" class="form-control bg-secondary text-light" rows="3" placeholder="Describe la experiencia laboral"></textarea>
            </div>
            <div class="form-group col-md-6">
                <label for="fecha_contratacion">Fecha de Contratación</label>
                <input type="date" name="fecha_contratacion" id="fecha_contratacion" class="form-control bg-secondary text-light" required>
            </div>
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

        <!-- Botón Guardar -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg">Guardar Empleado</button>
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
