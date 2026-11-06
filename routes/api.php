<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index']);

use App\Http\Controllers\Api\TransactionController;

Route::post('/transactions', [TransactionController::class, 'store']);