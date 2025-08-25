<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas explícitas para el controlador de usuarios protegidas con Sanctum
// Rutas públicas para libros
Route::get('books', [App\Http\Controllers\BookController::class, 'index']); // Listar libros
Route::get('books/{id}', [App\Http\Controllers\BookController::class, 'show']); // Mostrar libro

// Rutas protegidas para usuarios y administración de libros
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('users', [App\Http\Controllers\UserController::class, 'index']); // Listar usuarios
    Route::get('users/{id}', [App\Http\Controllers\UserController::class, 'show']); // Mostrar usuario
    Route::post('users', [App\Http\Controllers\UserController::class, 'store']); // Crear usuario
    Route::put('users/{id}', [App\Http\Controllers\UserController::class, 'update']); // Actualizar usuario
    Route::delete('users/{id}', [App\Http\Controllers\UserController::class, 'destroy']); // Eliminar usuario

    // Rutas protegidas para crear, actualizar y eliminar libros
    Route::post('books', [App\Http\Controllers\BookController::class, 'store']); // Crear libro
    Route::put('books/{id}', [App\Http\Controllers\BookController::class, 'update']); // Actualizar libro
    Route::delete('books/{id}', [App\Http\Controllers\BookController::class, 'destroy']); // Eliminar libro

    // Rutas protegidas para el controlador de órdenes
    Route::get('orders', [App\Http\Controllers\OrderController::class, 'index']); // Listar órdenes
    Route::get('orders/{id}', [App\Http\Controllers\OrderController::class, 'show']); // Mostrar orden
    Route::post('orders', [App\Http\Controllers\OrderController::class, 'store']); // Crear orden
    Route::put('orders/{id}', [App\Http\Controllers\OrderController::class, 'update']); // Actualizar orden
    Route::delete('orders/{id}', [App\Http\Controllers\OrderController::class, 'destroy']); // Eliminar orden

    // Rutas protegidas para el controlador de OrderItem
    Route::get('order-items', [App\Http\Controllers\OrderItemController::class, 'index']); // Listar items de orden
    Route::get('order-items/{id}', [App\Http\Controllers\OrderItemController::class, 'show']); // Mostrar item de orden
    Route::post('order-items', [App\Http\Controllers\OrderItemController::class, 'store']); // Crear item de orden
    Route::put('order-items/{id}', [App\Http\Controllers\OrderItemController::class, 'update']); // Actualizar item de orden
    Route::delete('order-items/{id}', [App\Http\Controllers\OrderItemController::class, 'destroy']); // Eliminar item de orden

    // Rutas protegidas para el controlador de direcciones
    Route::get('directions', [App\Http\Controllers\DirectionController::class, 'index']); // Listar direcciones
    Route::get('directions/{id}', [App\Http\Controllers\DirectionController::class, 'show']); // Mostrar dirección
    Route::post('directions', [App\Http\Controllers\DirectionController::class, 'store']); // Crear dirección
    Route::put('directions/{id}', [App\Http\Controllers\DirectionController::class, 'update']); // Actualizar dirección
    Route::delete('directions/{id}', [App\Http\Controllers\DirectionController::class, 'destroy']); // Eliminar dirección
    // Rutas protegidas para el controlador de pagos
    Route::get('payments', [App\Http\Controllers\PaymentController::class, 'index']); // Listar pagos
    Route::get('payments/{id}', [App\Http\Controllers\PaymentController::class, 'show']); // Mostrar pago
    Route::post('payments', [App\Http\Controllers\PaymentController::class, 'store']); // Crear pago
    Route::put('payments/{id}', [App\Http\Controllers\PaymentController::class, 'update']); // Actualizar pago
    Route::delete('payments/{id}', [App\Http\Controllers\PaymentController::class, 'destroy']); // Eliminar pago

    // Rutas protegidas para el controlador de progreso de lectura
    Route::get('reading-progress', [App\Http\Controllers\ReadingProgressController::class, 'index']); // Listar progreso
    Route::get('reading-progress/{id}', [App\Http\Controllers\ReadingProgressController::class, 'show']); // Mostrar progreso
    Route::post('reading-progress', [App\Http\Controllers\ReadingProgressController::class, 'store']); // Crear progreso
    Route::put('reading-progress/{id}', [App\Http\Controllers\ReadingProgressController::class, 'update']); // Actualizar progreso
    Route::delete('reading-progress/{id}', [App\Http\Controllers\ReadingProgressController::class, 'destroy']); // Eliminar progreso

    // Rutas protegidas para el controlador de Wishlist
    Route::get('wishlists', [App\Http\Controllers\WishlistController::class, 'index']); // Listar wishlist
    Route::get('wishlists/{id}', [App\Http\Controllers\WishlistController::class, 'show']); // Mostrar item de wishlist
    Route::post('wishlists', [App\Http\Controllers\WishlistController::class, 'store']); // Agregar a wishlist
    Route::delete('wishlists/{id}', [App\Http\Controllers\WishlistController::class, 'destroy']); // Eliminar de wishlist

    // Rutas protegidas para el controlador de Review
    Route::get('reviews', [App\Http\Controllers\ReviewController::class, 'index']); // Listar reviews
    Route::get('reviews/{id}', [App\Http\Controllers\ReviewController::class, 'show']); // Mostrar review
    Route::post('reviews', [App\Http\Controllers\ReviewController::class, 'store']); // Crear review
    Route::put('reviews/{id}', [App\Http\Controllers\ReviewController::class, 'update']); // Actualizar review
    Route::delete('reviews/{id}', [App\Http\Controllers\ReviewController::class, 'destroy']); // Eliminar review
});
