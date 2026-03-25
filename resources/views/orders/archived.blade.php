@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span><svg class="icon me-2"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-archive') }}"></use></svg> Pedidos Archivados</span>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary">Volver a Pedidos Activos</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Número Cliente</th>
                                <th>Número Factura</th>
                                <th>Estado</th>
                                <th>Fecha Pedido</th>
                                <th>Monto Total</th>
                                <th>Usuario</th>
                                <th>Fecha Eliminación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($archivedOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->customer_number }}</td>
                                    <td>{{ $order->invoice_number }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'in_route' ? 'warning' : ($order->status === 'in_process' ? 'info' : 'secondary')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->order_date->format('d/m/Y') }}</td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->deleted_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('orders.restore', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas restaurar este pedido?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <svg class="icon me-1"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-reload') }}"></use></svg> Restaurar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No hay pedidos archivados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $archivedOrders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection