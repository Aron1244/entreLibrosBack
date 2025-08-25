<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderItemController extends Controller
{
    // List all order items
    public function index()
    {
        $items = OrderItem::with(['order', 'book'])->get();
        return response()->json($items);
    }

    // Show a single order item
    public function show($id)
    {
        $item = OrderItem::with(['order', 'book'])->find($id);
        if (!$item) {
            return response()->json(['message' => 'Order item not found'], 404);
        }
        return response()->json($item);
    }

    // Create a new order item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'book_id' => 'required|exists:books,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric',
            'subtotal' => 'required|numeric',
        ]);
        $item = OrderItem::create($validated);
        return response()->json($item, 201);
    }

    // Update an existing order item
    public function update(Request $request, $id)
    {
        $item = OrderItem::find($id);
        if (!$item) {
            return response()->json(['message' => 'Order item not found'], 404);
        }
        $validated = $request->validate([
            'order_id' => 'sometimes|exists:orders,id',
            'book_id' => 'sometimes|exists:books,id',
            'cantidad' => 'sometimes|integer|min:1',
            'precio_unitario' => 'sometimes|numeric',
            'subtotal' => 'sometimes|numeric',
        ]);
        $item->update($validated);
        return response()->json($item);
    }

    // Delete an order item
    public function destroy($id)
    {
        $item = OrderItem::find($id);
        if (!$item) {
            return response()->json(['message' => 'Order item not found'], 404);
        }
        $item->delete();
        return response()->json(['message' => 'Order item deleted']);
    }
}
