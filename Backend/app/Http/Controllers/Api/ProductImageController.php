<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => ProductImage::with('product')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'image_url' => 'required|string|max:255',
            'is_primary' => 'nullable|boolean',
        ]);

        $productImage = ProductImage::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product image created successfully.',
            'data' => $productImage
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductImage $productImage)
    {
        return response()->json([
            'success' => true,
            'data' => $productImage->load('product')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductImage $productImage)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'image_url' => 'required|string|max:255',
            'is_primary' => 'nullable|boolean',
        ]);

        $productImage->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Product image updated successfully.',
            'data' => $productImage
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductImage $productImage)
    {
        $productImage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product image deleted successfully.'
        ]);
    }
}
