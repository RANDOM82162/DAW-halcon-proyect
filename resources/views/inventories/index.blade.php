@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span><svg class="icon me-2"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-storage') }}"></use></svg> Gestión de Inventario</span>
                <a href="{{ route('inventories.create') }}" class="btn btn-sm btn-primary">Nuevo Inventario</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Ubicación</th>
                                <th>Fecha Creación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->id }}</td>
                                    <td>{{ $inventory->product_name }}</td>
                                    <td>{{ $inventory->quantity }}</td>
                                    <td>{{ $inventory->location ?? 'Sin especificar' }}</td>
                                    <td>{{ $inventory->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('inventories.show', $inventory) }}" class="btn btn-sm btn-secondary">
                                                <svg class="icon me-1"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-eye') }}"></use></svg> Ver
                                            </a>
                                            <a href="{{ route('inventories.edit', $inventory) }}" class="btn btn-sm btn-info text-white">
                                                <svg class="icon me-1"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-pencil') }}"></use></svg> Editar
                                            </a>

                                            <form action="{{ route('inventories.destroy', $inventory) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este registro de inventario?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger text-white">
                                                    <svg class="icon me-1"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-trash') }}"></use></svg> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay registros de inventario.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection