<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Order::with('customer', 'items')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'required|numeric',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'data' => $order
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json([
            'success' => true,
            'data' => $order->load('customer', 'items')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully.',
            'data' => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.'
        ]);
    }
}
