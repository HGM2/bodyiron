@extends('layouts.app')

@section('title', 'Agregar Notas a la Cita')

@section('content')
<div class="container mt-5">
    <h2 class="text-center text-white mb-4">Agregar Notas a la Cita</h2>

    <form action="{{ route('nutricionista.citas.addNotes', $appointmentId) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="notas" class="text-white">Notas</label>
            <textarea name="notas" id="notas" class="form-control" rows="4" required></textarea>
        </div>

        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">Guardar Notas</button>
        </div>
    </form>
</div>
@endsection
