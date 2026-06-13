<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Payment::with('order')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:cash,credit_card,paypal,bank_transfer',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,failed',
            'payment_date' => 'nullable|date',
        ]);

        $payment = Payment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment created successfully.',
            'data' => $payment
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return response()->json([
            'success' => true,
            'data' => $payment->load('order')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:cash,credit_card,paypal,bank_transfer',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,failed',
            'payment_date' => 'nullable|date',
        ]);

        $payment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment updated successfully.',
            'data' => $payment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
         $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully.'
        ]);
    }
}
