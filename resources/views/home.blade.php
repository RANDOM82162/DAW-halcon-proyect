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
                                <div class="mt-4 p-4 border rounded bg-light">
                                    <h5 class="mb-3 fw-bold">Información del Pedido</h5>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Número de Factura:</strong> {{ $order->invoice_number }}</p>
                                            <p class="mb-2"><strong>Número de Cliente:</strong> {{ $order->customer_number }}</p>
                                            <p class="mb-2"><strong>Monto Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Fecha de Pedido:</strong> {{ $order->order_date->format('d/m/Y') }}</p>
                                            <p class="mb-2"><strong>Estado:</strong> 
                                                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'in_route' ? 'warning' : ($order->status === 'in_process' ? 'info' : 'secondary')) }}">
                                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                </span>
                                            </p>
                                            @if($order->delivery_date)
                                                <p class="mb-2"><strong>Fecha de Entrega:</strong> {{ $order->delivery_date->format('d/m/Y') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($order->status == 'delivered')
                                        @if($order->delivery_photo)
                                            <div class="mt-4 pt-3 border-top">
                                                <h6 class="mb-3">Foto de Entrega</h6>
                                                <div class="text-center">
                                                    <img src="{{ Storage::url($order->delivery_photo) }}" alt="Foto de entrega" class="img-fluid rounded" style="max-width: 100%; max-height: 500px;">
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-4 pt-3 border-top">
                                                <p class="text-muted"><em>No hay foto de entrega disponible.</em></p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="mt-4 pt-3 border-top">
                                            <p class="text-muted"><em>La foto de entrega estará disponible cuando el pedido sea entregado.</em></p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="mt-4 alert alert-danger" role="alert">
                                    <svg class="icon me-2"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-info') }}"></use></svg>
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
