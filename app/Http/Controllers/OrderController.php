<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    // List all orders
    public function index()
    {
        $orders = Order::with(['user', 'items', 'payment'])->get();
        return response()->json($orders);
    }

    // Show a single order
    public function show($id)
    {
        $order = Order::with(['user', 'items', 'payment'])->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order);
    }

    // Create a new order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric',
            'estado' => 'required|string|max:255',
            'direction_id' => 'required|exists:directions,id',
        ]);

        // Obtener la dirección seleccionada
        $direction = \App\Models\Direction::find($validated['direction_id']);
        if (!$direction) {
            return response()->json(['message' => 'Direction not found'], 404);
        }

        // Guardar la dirección como string (puedes personalizar el formato)
        $direccion_envio = $direction->direccion . ', ' . $direction->ciudad . ', ' . $direction->region . ', ' . ($direction->codigo_postal ?? '') . ', ' . $direction->pais;

        $order = Order::create([
            'user_id' => $validated['user_id'],
            'total' => $validated['total'],
            'estado' => $validated['estado'],
            'direccion_envio' => $direccion_envio,
        ]);
        return response()->json($order, 201);
    }

    // Update an existing order
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'total' => 'sometimes|numeric',
            'estado' => 'sometimes|string|max:255',
            'direction_id' => 'sometimes|exists:directions,id',
        ]);

        $updateData = $validated;
        if (isset($validated['direction_id'])) {
            $direction = \App\Models\Direction::find($validated['direction_id']);
            if (!$direction) {
                return response()->json(['message' => 'Direction not found'], 404);
            }
            $updateData['direccion_envio'] = $direction->direccion . ', ' . $direction->ciudad . ', ' . $direction->region . ', ' . ($direction->codigo_postal ?? '') . ', ' . $direction->pais;
            unset($updateData['direction_id']);
        }
        $order->update($updateData);
        return response()->json($order);
    }

    // Delete an order
    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }
}
