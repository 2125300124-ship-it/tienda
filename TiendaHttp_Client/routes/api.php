<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\ProveedorController;
use App\Http\Controllers\Fakestoreapicontroller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin Token)
|--------------------------------------------------------------------------
*/

// Autenticación de Administradores
Route::post('/login', [AdminAuthController::class, 'login']);

// Endpoints de FakeStore de la actividad anterior
Route::get('/fakestore/productos', [Fakestoreapicontroller::class, 'productos']);
Route::get('/fakestore/productos/detalle/{id}', [Fakestoreapicontroller::class, 'productoById'])
    ->whereNumber('id');

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (Protegidas mediante Token SANCTUM)
|--------------------------------------------------------------------------
| Cualquier petición a estas rutas SIN token Bearer retornará HTTP 401 Unauthorized
*/
Route::middleware('auth:sanctum')->group(function () {

    // Sesión y verificación de token
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/perfil', [AdminAuthController::class, 'perfil']);

    // 1. Gestión de Administradores (tabla 'administradores')
    Route::apiResource('administradores', AdminController::class);

    // 2. Gestión de Productos (con soporte de imágenes)
    Route::apiResource('productos', ProductoController::class);
    // Ruta POST alternativa para actualización con multipart/form-data
    Route::post('productos/{id}', [ProductoController::class, 'update']);

    // 3. Gestión de Proveedores
    Route::apiResource('proveedores', ProveedorController::class);

    // 4. Gestión de Clientes
    Route::apiResource('clientes', ClienteController::class);

    // 5. Gestión de Pedidos
    Route::apiResource('pedidos', PedidoController::class);
});
