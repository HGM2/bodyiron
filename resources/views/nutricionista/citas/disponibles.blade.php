@extends('layouts.app')

@section('title', 'Horas Disponibles')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Horas Disponibles</h2>
    <div class="row mt-4">
        @if($citasDisponibles->isEmpty())
            <div class="col-12 text-center">
                <p class="text-danger">No hay citas disponibles.</p>
            </div>
        @else
            @foreach($citasDisponibles as $cita)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $cita->fecha_hora->format('d-m-Y H:i') }}</h5>
                            <p class="card-text">{{ $cita->descripcion }}</p>
                            <a href="#" class="btn btn-primary">Reservar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
