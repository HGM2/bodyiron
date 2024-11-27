@extends('adminlte::page')

@section('title', 'Gestión de Empleados')

@section('content_header')
    <h1 class="text-center bg-light py-3 rounded shadow" style="color: #000;">Gestión de Empleados</h1>
@stop

@section('content')
<div class="container mt-4" style="background: url('{{ asset('images/fondo6.jpg') }}') no-repeat center center fixed; background-size: cover; padding: 2rem; border-radius: 10px;">
    <!-- Botón Agregar -->
    <div class="text-center mb-4">
        <a href="{{ route('admin.empleados.create') }}" class="btn btn-success btn-lg shadow">
            <i class="fas fa-user-plus"></i> Agregar Empleado
        </a>
    </div>

    <!-- Tabla de Empleados -->
    <div class="table-responsive">
        <table id="empleadosTable" class="table table-bordered table-hover" style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px;">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Puesto</th>
                    <th>Fecha de Contratación</th>
                    <th>Experiencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $empleado)
                    <tr class="text-center align-middle">
                        <td>
                            <button class="btn btn-link p-0" data-toggle="modal" data-target="#employeeModal{{ $empleado->id }}">
                                @if($empleado->foto && file_exists(public_path('storage/' . $empleado->foto)))
                                    <img src="{{ asset('storage/' . $empleado->foto) }}" alt="Foto de {{ $empleado->nombre }}" class="img-thumbnail" width="50">
                                @else
                                    <span class="text-muted">Sin foto</span>
                                @endif
                            </button>
                        </td>
                        <td>{{ $empleado->nombre }}</td>
                        <td>{{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</td>
                        <td>{{ ucfirst($empleado->puesto) }}</td>
                        <td>{{ $empleado->fecha_contratacion ? \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d/m/Y') : 'N/A' }}</td>
                        <td>{{ $empleado->experiencia }}</td>
                        <td>
                            <a href="{{ route('admin.empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $empleado->id }}">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </td>
                    </tr>

                    <!-- Modal para Ver Información del Empleado -->
                    <div class="modal fade" id="employeeModal{{ $empleado->id }}" tabindex="-1" aria-labelledby="employeeModalLabel{{ $empleado->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content bg-dark text-white">
                                <div class="modal-header border-bottom border-secondary">
                                    <h5 class="modal-title" id="employeeModalLabel{{ $empleado->id }}">Información de {{ $empleado->nombre }}</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            @if($empleado->foto && file_exists(public_path('storage/' . $empleado->foto)))
                                                <img src="{{ asset('storage/' . $empleado->foto) }}" alt="Foto de {{ $empleado->nombre }}" class="img-fluid rounded-circle shadow">
                                            @else
                                                <span class="text-muted">Sin foto</span>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <ul class="list-group">
                                                <li class="list-group-item bg-dark text-white border-secondary"><strong>Nombre:</strong> {{ $empleado->nombre }}</li>
                                                <li class="list-group-item bg-dark text-white border-secondary"><strong>Apellidos:</strong> {{ $empleado->apellido_paterno }} {{ $empleado->apellido_materno }}</li>
                                                <li class="list-group-item bg-dark text-white border-secondary"><strong>Email:</strong> {{ $empleado->email }}</li>
                                                <li class="list-group-item bg-dark text-white border-secondary"><strong>Puesto:</strong> {{ ucfirst($empleado->puesto) }}</li>
                                                <li class="list-group-item bg-dark text-white border-secondary"><strong>Salario por Hora:</strong> ${{ number_format($empleado->salario_hora, 2) }}</li>
                                                <li class="list-group-item bg-dark text-white border-secondary"><strong>Fecha de Contratación:</strong> {{ $empleado->fecha_contratacion ? \Carbon\Carbon::parse($empleado->fecha_contratacion)->format('d/m/Y') : 'N/A' }}</li>
                                                <li class="list-group-item bg-dark text-white border-secondary"><strong>Experiencia:</strong> {{ $empleado->experiencia }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-top border-secondary">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para Confirmar Eliminación -->
                    <div class="modal fade" id="deleteModal{{ $empleado->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $empleado->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-white">
                                <div class="modal-header border-bottom border-danger">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $empleado->id }}">Confirmar Eliminación</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro de que deseas eliminar al empleado <strong>{{ $empleado->nombre }} {{ $empleado->apellido_paterno }}</strong>?</p>
                                    <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
                                </div>
                                <div class="modal-footer border-top border-danger">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('admin.empleados.destroy', $empleado->id) }}" method="POST">
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

@section('css')
    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#empleadosTable').DataTable({
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros en total)",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "pageLength": 10,
            "lengthChange": false,
            "searching": true,
            "order": [[1, "asc"]]
        });
    });
</script>
@stop
