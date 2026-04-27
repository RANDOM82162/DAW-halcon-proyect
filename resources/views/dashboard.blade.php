@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                Bienvenido
            </div>
            <div class="card-body">
                <p>Este es el panel de control de la aplicación.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Usuarios</h5>
                <p class="card-text">Gestionar usuarios del sistema</p>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Ver Usuarios</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Pedidos</h5>
                <p class="card-text">Gestionar pedidos activos</p>
                <a href="{{ route('orders.index') }}" class="btn btn-primary">Ver Pedidos</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Pedidos Archivados</h5>
                <p class="card-text">Ver y restaurar pedidos archivados</p>
                <a href="{{ route('orders.archived') }}" class="btn btn-primary">Ver Archivados</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Inventario</h5>
                <p class="card-text">Gestionar inventario de productos</p>
                <a href="{{ route('inventories.index') }}" class="btn btn-primary">Ver Inventario</a>
            </div>
        </div>
    </div>
</div>
@endsection