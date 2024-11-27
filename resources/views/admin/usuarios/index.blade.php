@extends('adminlte::page')

@section('title', 'Gestión de Usuarios')

@section('content_header')
    <h1 class="text-white text-center bg-dark p-3 rounded">Gestión de Usuarios</h1>
@stop

@section('content')
<div class="container mt-4" style="background: url('{{ asset('images/fondo1.jpg') }}') no-repeat center center fixed; background-size: cover; padding: 2rem; border-radius: 10px;">
    <a href="{{ route('admin.usuarios.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-user-plus"></i> Agregar Usuario
    </a>

    <div class="table-responsive">
        <table id="usuariosTable" class="table table-bordered table-hover table-striped" style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px; overflow: hidden;">
            <thead class="thead-dark text-center">
                <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <td class="text-center">
                        @if($usuario->foto && file_exists(public_path('storage/' . $usuario->foto)))
                            <img src="{{ asset('storage/' . $usuario->foto) }}" alt="Foto de {{ $usuario->nombre }}" class="rounded-circle img-thumbnail" width="50" height="50" data-toggle="modal" data-target="#userModal{{ $usuario->id }}">
                        @else
                            <span class="text-muted">Sin foto</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $usuario->nombre }}</td>
                    <td class="text-center">{{ $usuario->apellido_paterno }}</td>
                    <td class="text-center">{{ $usuario->apellido_materno }}</td>
                    <td class="text-center">{{ $usuario->email }}</td>
                    <td class="text-center">
                        <span class="badge badge-primary text-uppercase">{{ ucfirst($usuario->tipo) }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Modal para mostrar datos del usuario -->
                <div class="modal fade" id="userModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="userModalLabel{{ $usuario->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title" id="userModalLabel{{ $usuario->id }}">Datos del Usuario</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                @if($usuario->foto && file_exists(public_path('storage/' . $usuario->foto)))
                                    <img src="{{ asset('storage/' . $usuario->foto) }}" alt="Foto de {{ $usuario->nombre }}" class="rounded-circle img-fluid mb-3" width="100" height="100">
                                @else
                                    <p class="text-muted">Sin foto disponible</p>
                                @endif
                                <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
                                <p><strong>Apellido Paterno:</strong> {{ $usuario->apellido_paterno }}</p>
                                <p><strong>Apellido Materno:</strong> {{ $usuario->apellido_materno }}</p>
                                <p><strong>Email:</strong> {{ $usuario->email }}</p>
                                <p><strong>Tipo:</strong> {{ ucfirst($usuario->tipo) }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
        $('#usuariosTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            "pageLength": 10,
            "lengthChange": false,
            "searching": true,
            "order": [[1, "asc"]],
            "columnDefs": [
                { "orderable": false, "targets": [0, 6] } // Foto y Acciones no ordenables
            ]
        });
    });
</script>
@stop
