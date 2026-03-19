@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold">
                <span><svg class="icon me-2"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-pencil') }}"></use></svg> Editar Pedido #{{ $order->id }}</span>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="customer_number" class="form-label">Número de Cliente</label>
                            <input type="text" class="form-control @error('customer_number') is-invalid @enderror" id="customer_number" name="customer_number" value="{{ old('customer_number', $order->customer_number) }}" required>
                            @error('customer_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="invoice_number" class="form-label">Número de Factura</label>
                            <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $order->invoice_number) }}" required>
                            @error('invoice_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Estado</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">Seleccionar estado</option>
                            <option value="ordered" {{ old('status', $order->status) == 'ordered' ? 'selected' : '' }}>Ordenado</option>
                            <option value="in_process" {{ old('status', $order->status) == 'in_process' ? 'selected' : '' }}>En proceso</option>
                            <option value="in_route" {{ old('status', $order->status) == 'in_route' ? 'selected' : '' }}>En ruta</option>
                            <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>Entregado</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="order_date" class="form-label">Fecha de Pedido</label>
                            <input type="date" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" value="{{ old('order_date', $order->order_date->format('Y-m-d')) }}" required>
                            @error('order_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="delivery_date" class="form-label">Fecha de Entrega</label>
                            <input type="date" class="form-control @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', $order->delivery_date ? $order->delivery_date->format('Y-m-d') : '') }}">
                            @error('delivery_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Monto Total</label>
                        <input type="number" step="0.01" class="form-control @error('total_amount') is-invalid @enderror" id="total_amount" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}" required>
                        @error('total_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notas</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $order->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection