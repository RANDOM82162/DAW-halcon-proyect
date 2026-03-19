@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span><svg class="icon me-2"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-cart') }}"></use></svg> Detalles del Pedido #{{ $order->id }}</span>
                <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-primary">Editar</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Número de Cliente:</strong>
                        <p>{{ $order->customer_number }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Número de Factura:</strong>
                        <p>{{ $order->invoice_number }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Estado:</strong>
                        <p>
                            <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'in_route' ? 'warning' : ($order->status === 'in_process' ? 'info' : 'secondary')) }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong>Usuario que creó:</strong>
                        <p>{{ $order->user->name }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Fecha de Pedido:</strong>
                        <p>{{ $order->order_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Fecha de Entrega:</strong>
                        <p>{{ $order->delivery_date ? $order->delivery_date->format('d/m/Y') : 'No especificada' }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Monto Total:</strong>
                    <p>${{ number_format($order->total_amount, 2) }}</p>
                </div>

                <div class="mb-3">
                    <strong>Notas:</strong>
                    <p>{{ $order->notes ?: 'Sin notas' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Fecha de Creación:</strong>
                    <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Volver a la Lista</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection