@extends('layouts.app')

@section('content')
@if(auth()->check())
    <!-- Dashboard para usuarios autenticados -->
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
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Usuarios</h5>
                    <p class="card-text">Gestionar usuarios del sistema</p>
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Ver Usuarios</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Pedidos</h5>
                    <p class="card-text">Gestionar pedidos activos</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Ver Pedidos</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Pedidos Archivados</h5>
                    <p class="card-text">Ver y restaurar pedidos archivados</p>
                    <a href="{{ route('orders.archived') }}" class="btn btn-primary">Ver Archivados</a>
                </div>
            </div>
        </div>
    </div>
@else
    <!-- Vista para usuarios no registrados -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Buscar Pedido') }}</div>

                    <div class="card-body">
                        <form method="GET" action="{{ route('home') }}">
                            <div class="form-group mb-3">
                                <label for="invoice_number">Número de Factura</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </form>

                        @if($searched)
                            @if($order)
                                @if($order->status == 'delivered')
                                    <div class="mt-4">
                                        <h5>Pedido Encontrado</h5>
                                        <p>Estado: Entregado</p>
                                        <p>No hay foto de entrega disponible.</p>
                                    </div>
                                @elseif($order->status == 'in_process')
                                    <div class="mt-4">
                                        <h5>Pedido Encontrado</h5>
                                        <p>Estado: En Proceso</p>
                                        <p>Proceso: {{ $order->status }}</p>
                                        <p>Fecha: {{ $order->delivery_date ? $order->delivery_date->format('d/m/Y') : 'No especificada' }}</p>
                                    </div>
                                @else
                                    <div class="mt-4">
                                        <h5>Pedido Encontrado</h5>
                                        <p>Estado: {{ $order->status }}</p>
                                    </div>
                                @endif
                            @else
                                <div class="mt-4 alert alert-danger">
                                    No se encontró ningún pedido con ese número de factura.
                                </div>
                            @endif
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-secondary">Iniciar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
