@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span><svg class="icon me-2"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-eye') }}"></use></svg> Detalles del Inventario</span>
                <a href="{{ route('inventories.edit', $inventory) }}" class="btn btn-sm btn-primary">Editar</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">ID:</div>
                    <div class="col-sm-9">{{ $inventory->id }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Producto:</div>
                    <div class="col-sm-9">{{ $inventory->product_name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Cantidad:</div>
                    <div class="col-sm-9">{{ $inventory->quantity }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Ubicación:</div>
                    <div class="col-sm-9">{{ $inventory->location ?? 'Sin especificar' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Fecha de Creación:</div>
                    <div class="col-sm-9">{{ $inventory->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Última Actualización:</div>
                    <div class="col-sm-9">{{ $inventory->updated_at->format('d/m/Y H:i') }}</div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('inventories.index') }}" class="btn btn-secondary me-2">Volver al Listado</a>
                    <a href="{{ route('inventories.edit', $inventory) }}" class="btn btn-primary">Editar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection