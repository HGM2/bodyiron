@extends('adminlte::page')

@section('title', 'Gestión de Clases')

@section('content_header')
    <h1 class="text-center bg-dark text-white py-3 rounded">Gestión de Clases</h1>
@stop

@section('content')
<div class="container mt-4" style="background: url('{{ asset('images/fondo9.jpg') }}') no-repeat center center fixed; background-size: cover; padding: 2rem; border-radius: 10px;">
    <a href="{{ route('admin.classes.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus-circle"></i> Agregar Clase
    </a>

    <div class="table-responsive">
        <table id="clasesTable" class="table table-bordered table-hover table-striped" style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px;">
            <thead class="thead-dark text-center">
                <tr>
                    <th>Nombre</th>
                    <th>Fecha y Hora</th>
                    <th>Entrenador</th>
                    <th>Participantes Máximos</th>
                    <th>Lugar</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clases as $clase)
                <tr>
                    <td class="text-center">{{ $clase->nombre }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($clase->fecha_hora)->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        {{ $clase->empleado ? $clase->empleado->nombre . ' ' . $clase->empleado->apellido_paterno : 'Sin asignar' }}
                    </td>
                    <td class="text-center">{{ $clase->num_max_participantes }}</td>
                    <td class="text-center">{{ $clase->lugar }}</td>
                    <td class="text-center">{{ $clase->descripcion }}</td>
                    <td class="text-center">
                        <!-- Botón para editar -->
                        <a href="{{ route('admin.classes.edit', $clase->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <!-- Botón para eliminar -->
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $clase->id }}">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>

                        <!-- Botón para checklist -->
                        <a href="{{ route('admin.classes.attendance', $clase->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-check-circle"></i> Checklist
                        </a>
                    </td>
                </tr>

                <!-- Modal de confirmación para eliminar -->
                <div class="modal fade" id="deleteModal{{ $clase->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $clase->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="deleteModalLabel{{ $clase->id }}">Confirmar Eliminación</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de que deseas eliminar la clase <strong>{{ $clase->nombre }}</strong>?</p>
                                <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="{{ route('admin.classes.destroy', $clase->id) }}" method="POST">
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
        $('#clasesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            "pageLength": 10,
            "lengthChange": false,
            "searching": true,
            "order": [[1, "asc"]],
            "columnDefs": [
                { "orderable": false, "targets": [6] } // Deshabilitar orden en la columna de acciones
            ]
        });
    });
</script>
@stop
