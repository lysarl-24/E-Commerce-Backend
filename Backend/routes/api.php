<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\InventoryTransactionController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('product-images', ProductImageController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-items', OrderItemController::class);
Route::apiResource('payments', PaymentController::class);
Route::apiResource('inventory-transactions', InventoryTransactionController::class);
