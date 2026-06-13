<?php

namespace App\Http\Controllers\Api;

use App\Models\InventoryTransaction;
use Illuminate\Http\Request;

class InventoryTransactionController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return response()->json([
            'success' => true,
            'data' => InventoryTransaction::with('product')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'transaction_type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $transaction = InventoryTransaction::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Inventory transaction created successfully.',
            'data' => $transaction
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryTransaction $inventoryTransaction)
    {
        return response()->json([
            'success' => true,
            'data' => $inventoryTransaction->load('product')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryTransaction $inventoryTransaction)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'transaction_type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $inventoryTransaction->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Inventory transaction updated successfully.',
            'data' => $inventoryTransaction
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryTransaction $inventoryTransaction)
    {
        $inventoryTransaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inventory transaction deleted successfully.'
        ]);
    }
}
