<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Order::with('user');

            if ($request->boolean('archived')) {
                $query = $query->onlyTrashed();
            }

            $orders = $query->paginate(15);
            return response()->json($orders, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_number' => 'required|string|max:255',
                'invoice_number' => 'required|string|max:255|unique:orders',
                'status' => 'required|in:pendiente,en-proceso,en-transito,entregado',
                'order_date' => 'required|date',
                'delivery_date' => 'nullable|date|after_or_equal:order_date',
                'total_amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string',
            ]);

            $validated['user_id'] = auth()->id() ?? 1;
            $order = Order::create($validated);

            return response()->json($order, Response::HTTP_CREATED);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        try {
            $order->load('user');
            return response()->json($order, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        try {
            $validated = $request->validate([
                'customer_number' => 'sometimes|string|max:255',
                'invoice_number' => 'sometimes|string|max:255|unique:orders,invoice_number,' . $order->id,
                'status' => 'sometimes|in:pendiente,en-proceso,en-transito,entregado',
                'order_date' => 'sometimes|date',
                'delivery_date' => 'nullable|date|after_or_equal:order_date',
                'total_amount' => 'sometimes|numeric|min:0',
                'notes' => 'nullable|string',
            ]);

            $order->update($validated);
            return response()->json($order, Response::HTTP_OK);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return response()->json(['message' => 'Pedido eliminado'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Restore an archived order.
     */
    public function restore($id)
    {
        try {
            $order = Order::withTrashed()->findOrFail($id);

            if (!$order->trashed()) {
                return response()->json(['message' => 'El pedido no está archivado'], Response::HTTP_BAD_REQUEST);
            }

            $order->restore();
            $order->load('user');
            return response()->json($order, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Permanently delete an archived order.
     */
    public function forceDestroy($id)
    {
        try {
            $order = Order::withTrashed()->findOrFail($id);

            if (!$order->trashed()) {
                return response()->json(['message' => 'El pedido no está archivado'], Response::HTTP_BAD_REQUEST);
            }

            $order->forceDelete();
            return response()->json(['message' => 'Pedido eliminado permanentemente'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Search an order publicly by id, invoice_number, or customer_number.
     */
    public function publicSearch($identifier)
    {
        try {
            // Strip 'PED-' prefix if present to allow searching by formatted order number
            $numericId = preg_replace('/^PED-/i', '', $identifier);

            $order = Order::where('id', $numericId)
                ->orWhere('invoice_number', $identifier)
                ->orWhere('customer_number', $identifier)
                ->first();

            if (!$order) {
                return response()->json(['message' => 'Pedido no encontrado'], Response::HTTP_NOT_FOUND);
            }

            return response()->json($order, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Upload delivery photo for an order.
     */
    public function uploadPhoto(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            // Manual check for file existence to provide better error messages
            if (!$request->hasFile('photo')) {
                return response()->json(['message' => 'No se detectó ningún archivo en la petición. Asegúrate de adjuntar una imagen válida y que no exceda el límite de PHP (2MB por defecto).'], Response::HTTP_BAD_REQUEST);
            }

            $file = $request->file('photo');

            if (!$file->isValid()) {
                return response()->json(['message' => 'El archivo subido está corrupto o es inválido. ' . $file->getErrorMessage()], Response::HTTP_BAD_REQUEST);
            }

            $path = $file->store('delivery_photos', 'public');
            if (!$path) {
                return response()->json(['message' => 'El servidor no pudo guardar el archivo en el disco.'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $order->delivery_photo = Storage::url($path);
            $order->save();
            
            return response()->json([
                'message' => 'Foto de entrega subida exitosamente',
                'delivery_photo' => $order->delivery_photo
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error interno: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
