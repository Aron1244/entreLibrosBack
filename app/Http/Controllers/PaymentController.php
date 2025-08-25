<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    // List all payments
    public function index()
    {
        $payments = Payment::with('order')->get();
        return response()->json($payments);
    }

    // Show a single payment
    public function show($id)
    {
        $payment = Payment::with('order')->find($id);
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }
        return response()->json($payment);
    }

    // Create a new payment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'monto' => 'required|numeric',
            'metodo' => 'required|in:transbank,mercadopago',
            'transaction_token' => 'nullable|string',
            'status' => 'nullable|string',
            'response_code' => 'nullable|string',
            'authorization_code' => 'nullable|string',
            'response_data' => 'nullable|array',
        ]);

        // Guardar el método de pago en response_data para referencia
        $data = $validated;
        $data['response_data'] = $validated['response_data'] ?? [];
        $data['response_data']['metodo'] = $validated['metodo'];
        unset($data['metodo']);

        $payment = Payment::create($data);
        return response()->json($payment, 201);
    }

    // Update an existing payment
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }
        $validated = $request->validate([
            'monto' => 'sometimes|numeric',
            'status' => 'nullable|string',
            'response_code' => 'nullable|string',
            'authorization_code' => 'nullable|string',
            'response_data' => 'nullable|array',
            'transaction_token' => 'nullable|string',
            'metodo' => 'nullable|in:transbank,mercadopago',
        ]);
        $updateData = $validated;
        if (isset($validated['metodo'])) {
            $updateData['response_data'] = $payment->response_data ?? [];
            $updateData['response_data']['metodo'] = $validated['metodo'];
            unset($updateData['metodo']);
        }
        $payment->update($updateData);
        return response()->json($payment);
    }

    // Delete a payment
    public function destroy($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }
        $payment->delete();
        return response()->json(['message' => 'Payment deleted']);
    }
}
