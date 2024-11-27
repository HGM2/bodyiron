@extends('adminlte::page')

@section('title', 'Gestión de Membresías')

@section('content_header')
    <h1 class="text-white text-center bg-dark p-3 rounded">Gestión de Membresías</h1>
@stop

@section('content')
<div class="container mt-4" style="background: url('{{ asset('images/fondo8.jpg') }}') no-repeat center center fixed; background-size: cover; padding: 2rem; border-radius: 10px;">
    <a href="{{ route('admin.memberships.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Agregar Membresía
    </a>

    <div class="table-responsive">
        <table id="membershipsTable" class="table table-bordered table-hover table-striped" style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px; overflow: hidden;">
            <thead class="thead-dark text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Duración (meses)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($memberships as $membership)
                <tr>
                    <td class="text-center">{{ $membership->nombre }}</td>
                    <td class="text-center">{{ $membership->descripcion }}</td>
                    <td class="text-center">${{ number_format($membership->precio, 2) }}</td>
                    <td class="text-center">{{ $membership->duracion }}</td>
                    <td class="text-center">
                        <!-- Botón para editar -->
                        <a href="{{ route('admin.memberships.edit', $membership->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <!-- Botón para eliminar -->
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $membership->id }}">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </td>
                </tr>

                <!-- Modal de confirmación para eliminar -->
                <div class="modal fade" id="deleteModal{{ $membership->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $membership->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="deleteModalLabel{{ $membership->id }}">Confirmar Eliminación</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de que deseas eliminar la membresía <strong>{{ $membership->nombre }}</strong>?</p>
                                <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="{{ route('admin.memberships.destroy', $membership->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#membershipsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            "pageLength": 10,
            "lengthChange": false,
            "searching": true,
            "order": [[0, "asc"]],
            "columnDefs": [
                { "orderable": false, "targets": [4] } // Acciones no ordenables
            ]
        });
    });
</script>
@stop
