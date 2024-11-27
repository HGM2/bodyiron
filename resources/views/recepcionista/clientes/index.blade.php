@extends('adminlte::page')

@section('title', 'Gestión de Clientes')

@section('content_header')
    <h1 class="text-light text-center bg-dark py-2">Gestión de Clientes</h1>
@stop

@section('content')
<div class="container-fluid" style="background: url('{{ asset('images/fondo2.jpg') }}') no-repeat center center fixed; background-size: cover; padding: 2rem; border-radius: 10px;">
    <div class="mb-4 text-center">
        <a href="{{ route('recepcion.clientes.create') }}" class="btn btn-primary btn-lg shadow">Agregar Cliente</a>
        <a href="{{ route('recepcion.clientes.reporte') }}" class="btn btn-info btn-lg shadow">Generar Reporte Mensual</a>
        <a href="{{ route('exportar.clientes') }}" class="btn btn-primary">
            Descargar Clientes en Excel
        </a>
        
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <table id="clientesTable" class="table table-striped table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">Foto</th>
                        <th>Nombre</th>
                        <th>Membresía</th>
                        <th class="text-center">QR</th>
                        <th>Usuario</th>
                        <th class="text-center">Vigencia</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientes as $cliente)
                        <tr>
                            <td class="text-center">
                                <a href="#" data-toggle="modal" data-target="#modalCliente{{ $cliente->id }}">
                                    <img src="{{ $cliente->foto ? asset('storage/' . $cliente->foto) : asset('images/sin-foto.png') }}" alt="Foto de {{ $cliente->nombre }}" class="img-thumbnail" style="cursor: pointer;">
                                </a>
                            </td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->membresia->nombre ?? 'Sin membresía' }}</td>
                            <td class="text-center">
                                <a href="#" data-toggle="modal" data-target="#modalQR{{ $cliente->id }}">
                                    @if($cliente->qr_codigo && file_exists(public_path('storage/' . $cliente->qr_codigo)))
                                        <img src="{{ asset('storage/' . $cliente->qr_codigo) }}" alt="QR de {{ $cliente->nombre }}" class="img-thumbnail" style="cursor: pointer;">
                                    @else
                                        <span class="badge badge-warning">No asignado</span>
                                    @endif
                                </a>
                            </td>
                            <td>{{ $cliente->username }}</td>
                            <td class="text-center">
                                @php
                                    $vencimiento = $cliente->fecha_vencimiento ? \Carbon\Carbon::parse($cliente->fecha_vencimiento) : null;
                                    $hoy = \Carbon\Carbon::now();
                                @endphp
                                @if($vencimiento)
                                    <span class="badge {{ $vencimiento->greaterThanOrEqualTo($hoy) ? 'badge-success' : 'badge-danger' }}">
                                        {{ $vencimiento->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="badge badge-warning">No asignada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('recepcion.clientes.edit', $cliente->id) }}">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <a class="dropdown-item text-success" href="{{ route('recepcion.clientes.pagar', $cliente->id) }}">
                                            <i class="fas fa-dollar-sign"></i> Pagar Membresía
                                        </a>
                                        <a class="dropdown-item text-primary" href="{{ route('recepcion.clientes.ticket', $cliente->id) }}">
                                            <i class="fas fa-file-pdf"></i> Generar Ticket
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('recepcion.clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Cliente -->
                        <div class="modal fade" id="modalCliente{{ $cliente->id }}" tabindex="-1" role="dialog" aria-labelledby="modalClienteLabel{{ $cliente->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content bg-dark text-light">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalClienteLabel{{ $cliente->id }}">Detalles de {{ $cliente->nombre }}</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ $cliente->foto ? asset('storage/' . $cliente->foto) : asset('images/sin-foto.png') }}" alt="Foto de {{ $cliente->nombre }}" class="img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
                                        <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
                                        <p><strong>Apellido:</strong> {{ $cliente->apellido_paterno }} {{ $cliente->apellido_materno }}</p>
                                        <p><strong>Email:</strong> {{ $cliente->email }}</p>
                                        <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                                        <p><strong>Usuario:</strong> {{ $cliente->username }}</p>
                                        <p><strong>Membresía:</strong> {{ $cliente->membresia->nombre ?? 'Sin membresía' }}</p>
                                        <p><strong>Fecha de Membresía:</strong> {{ $cliente->fecha_registro ? \Carbon\Carbon::parse($cliente->fecha_registro)->format('d/m/Y') : 'No asignada' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal QR -->
                        <div class="modal fade" id="modalQR{{ $cliente->id }}" tabindex="-1" role="dialog" aria-labelledby="modalQRLabel{{ $cliente->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content bg-dark text-light">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalQRLabel{{ $cliente->id }}">QR de {{ $cliente->nombre }}</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img src="{{ $cliente->qr_codigo ? asset('storage/' . $cliente->qr_codigo) : asset('images/sin-qr.png') }}" alt="QR de {{ $cliente->nombre }}" class="img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
                                        <a href="{{ $cliente->qr_codigo ? asset('storage/' . $cliente->qr_codigo) : '#' }}" class="btn btn-primary" download>
                                            <i class="fas fa-download"></i> Descargar QR
                                        </a>
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
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <style>
        .img-thumbnail {
            border-radius: 10px;
            object-fit: cover;
            height: 60px;
            width: 60px;
        }

        .modal-header {
            background-color: #343a40;
            color: #ffffff;
        }

        .modal-footer {
            background-color: #343a40;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#clientesTable').DataTable({
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
                }
            });
        });
    </script>
@stop
