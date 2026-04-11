@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span><svg class="icon me-2"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-image') }}"></use></svg> Foto de Entrega</span>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary">Volver</a>
            </div>
            <div class="card-body">
                <div class="mb-4 pb-3 border-bottom">
                    <h5 class="card-title">Información del Pedido</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Número de Factura:</strong> {{ $order->invoice_number }}</p>
                            <p class="mb-2"><strong>Cliente:</strong> {{ $order->customer_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Estado:</strong> 
                                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'in_route' ? 'warning' : ($order->status === 'in_process' ? 'info' : 'secondary')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </p>
                            <p class="mb-2"><strong>Monto Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>

                @if($order->delivery_photo)
                <div class="mb-4 pb-3 border-bottom">
                    <h5 class="card-subtitle mb-3">Foto Actual</h5>
                    <img src="{{ Storage::url($order->delivery_photo) }}" alt="Foto de entrega" class="img-fluid rounded" style="max-width: 100%; max-height: 400px;">
                </div>
                @endif

                <form action="{{ route('orders.storePhoto', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="delivery_photo" class="form-label">Seleccionar Foto de Entrega</label>
                        <input type="file" class="form-control @error('delivery_photo') is-invalid @enderror" id="delivery_photo" name="delivery_photo" accept="image/*" required>
                        @error('delivery_photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted">Formatos permitidos: JPEG, PNG, JPG, GIF. Máximo 2MB.</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <svg class="icon me-1"><use xlink:href="{{ asset('assets/icons/sprites/free.svg#cil-cloud-upload') }}"></use></svg> Guardar Foto
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
