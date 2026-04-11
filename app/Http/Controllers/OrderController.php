<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_number' => 'required|string|max:255',
            'invoice_number' => 'required|string|max:255|unique:orders',
            'status' => 'required|in:ordered,in_process,in_route,delivered',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        Order::create([
            'customer_number' => $request->customer_number,
            'invoice_number' => $request->invoice_number,
            'status' => $request->status,
            'order_date' => $request->order_date,
            'delivery_date' => $request->delivery_date,
            'total_amount' => $request->total_amount,
            'notes' => $request->notes,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('orders.index')->with('success', 'Pedido creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_number' => 'required|string|max:255',
            'invoice_number' => 'required|string|max:255|unique:orders,invoice_number,' . $order->id,
            'status' => 'required|in:ordered,in_process,in_route,delivered',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $order->update($request->only([
            'customer_number',
            'invoice_number',
            'status',
            'order_date',
            'delivery_date',
            'total_amount',
            'notes',
        ]));

        return redirect()->route('orders.index')->with('success', 'Pedido actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pedido eliminado correctamente.');
    }

    /**
     * Display a listing of archived (soft deleted) orders.
     */
    public function archived()
    {
        $archivedOrders = Order::onlyTrashed()->with('user')->paginate(10);
        return view('orders.archived', compact('archivedOrders'));
    }

    /**
     * Restore the specified archived order.
     */
    public function restore(Order $order)
    {
        $order->restore();
        return redirect()->route('orders.archived')->with('success', 'Pedido restaurado correctamente.');
    }

    /**
     * Show the form for uploading delivery photo.
     */
    public function photoForm(Order $order)
    {
        return view('orders.photo', compact('order'));
    }

    /**
     * Store the delivery photo.
     */
    public function storePhoto(Request $request, Order $order)
    {
        $request->validate([
            'delivery_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'delivery_photo.required' => 'Debe seleccionar una foto.',
            'delivery_photo.image' => 'El archivo debe ser una imagen.',
            'delivery_photo.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif.',
            'delivery_photo.max' => 'La imagen no debe superar 2MB.',
        ]);

        if ($request->hasFile('delivery_photo')) {
            // Eliminar la foto anterior si existe
            if ($order->delivery_photo && \Storage::exists('public/' . $order->delivery_photo)) {
                \Storage::delete('public/' . $order->delivery_photo);
            }

            // Almacenar la nueva foto
            $path = $request->file('delivery_photo')->store('deliveries', 'public');
            $order->update(['delivery_photo' => $path]);

            return redirect()->route('orders.index')->with('success', 'Foto de entrega guardada correctamente.');
        }

        return redirect()->back()->with('error', 'Error al procesar la foto.');
    }
}
