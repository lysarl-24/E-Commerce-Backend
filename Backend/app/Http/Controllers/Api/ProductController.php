<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return response()->json([
            'success' => true,
            'data' => Product::with('category', 'images')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'sku' => 'required|string|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'cost_price' => 'nullable|numeric',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => $product->load('category', 'images')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:150',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'cost_price' => 'nullable|numeric',
            'stock_quantity' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
