<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::post('/warehouses', [WarehouseController::class, 'store']);
Route::get('/warehouses/{pageId}', [WarehouseController::class, 'index']);
Route::delete('/warehouses/{warehouseId}/{moveWarehouseId}', [WarehouseController::class, 'destroy']);

Route::get('/products/{warehouseId}', [ProductController::class, 'index']);
Route::post('/products/{warehouseId}', [ProductController::class, 'store']);