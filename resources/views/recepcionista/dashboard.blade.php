@extends('adminlte::page')

@section('title', 'Dashboard Recepcionista')

@section('content_header')
    <h1 class="text-center bg-light py-3 rounded shadow" style="color: #000;">Dashboard de Recepción</h1>
@stop

@section('content')
<div class="container-fluid" style="background: url('{{ asset('images/fondo2.jpg') }}') no-repeat center center fixed; background-size: cover; min-height: 100vh;">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-8 col-lg-6">
            <div class="card bg-dark shadow-lg border-0 text-light">
                <div class="card-header text-center" style="background: linear-gradient(90deg, #c70000, #900000);">
                    <h2 class="font-weight-bold">{{ __('Panel de Recepción') }}</h2>
                </div>

                <div class="card-body">
                    <h3 class="text-center font-weight-bold mb-4">{{ __("Bienvenido al Panel de Recepción") }}</h3>
                    <p class="text-center text-muted">{{ __("Seleccione una de las opciones para continuar con las tareas.") }}</p>

                    <div class="row text-center">
                        <!-- Gestión de Clientes -->
                        <div class="col-6 mb-3">
                            <a href="{{ route('recepcion.clientes.index') }}" class="btn btn-outline-primary w-100 py-3 shadow">
                                <i class="fas fa-users fa-2x mb-2"></i><br>
                                Gestión de Clientes
                            </a>
                        </div>
                        <!-- Gestión de Membresías -->
                        <div class="col-6 mb-3">
                            <a href="{{ route('recepcion.membresias.index') }}" class="btn btn-outline-success w-100 py-3 shadow">
                                <i class="fas fa-id-card fa-2x mb-2"></i><br>
                                Gestión de Membresías
                            </a>
                        </div>
                        <!-- Editar Perfil -->
                        <div class="col-6 mb-3">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-warning w-100 py-3 shadow">
                                <i class="fas fa-user-edit fa-2x mb-2"></i><br>
                                Editar Perfil
                            </a>
                        </div>
                        <!-- Cerrar Sesión -->
                        <div class="col-6 mb-3">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-outline-danger w-100 py-3 shadow">
                                <i class="fas fa-sign-out-alt fa-2x mb-2"></i><br>
                                Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center text-muted">
                    <small>&copy; {{ date('Y') }} Body Iron Fitness - Todos los derechos reservados</small>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .btn-outline-primary:hover {
            background-color: #0056b3;
            color: white;
        }
        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }
        .btn-outline-warning:hover {
            background-color: #ffc107;
            color: white;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
    </style>
@stop
