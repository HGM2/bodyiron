@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-light">
                <div class="card-header bg-primary text-white">
                    <h2>{{ __('Dashboard') }}</h2>
                </div>

                <div class="card-body">
                    <h3 class="font-weight-bold">{{ __("Bienvenido al Dashboard") }}</h3>
                    <p>{{ __("Elija una opción para continuar:") }}</p>

                    <!-- Opciones según el rol del usuario -->
                    <div class="mt-4">
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mb-2">Ir al Panel de Administración</a>
                        @elseif (auth()->user()->role === 'nutricionista')
                            <a href="{{ route('nutricionista.dashboard') }}" class="btn btn-success mb-2">Ir al Panel de Nutricionista</a>
                        @elseif (auth()->user()->role === 'entrenador')
                            <a href="{{ route('entrenador.dashboard') }}" class="btn btn-warning mb-2">Ir al Panel de Entrenador</a>
                        @elseif (auth()->user()->role === 'recepcionista')
                            <a href="{{ route('recepcionista.dashboard') }}" class="btn btn-info mb-2">Ir al Panel de Recepcionista</a>
                        @else
                            <p class="text-muted">{{ __("No tiene un panel específico asignado.") }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
