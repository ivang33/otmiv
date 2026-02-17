<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LaundryItemController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\UserController;

Route::get('/test', function() {
    return ['message' => 'API работает'];
});

// Твои маршруты
Route::apiResource('laundry-items', LaundryItemController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('users', UserController::class)->except(['store']);
Route::post('/register', [UserController::class, 'store']);

// Lookup tables
Route::get('/categories', function () {
    return \App\Models\Category::all();
});
Route::get('/statuses', function () {
    return \App\Models\Status::all();
});
Route::get('/pickup-points', function () {
    return \App\Models\PickupPoint::all();
});
Route::get('/roles', function () {
    return \App\Models\Role::all();
});
