<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiResourceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CatalogoPublicoController;
use App\Http\Controllers\Api\ClienteAuthController;

Route::post('/login', [LoginController::class, 'login'])->name('api.login');

 // Catálogo público para Collector Store
    Route::get('/tienda/coleccionables',
    [CatalogoPublicoController::class, 'index']);

    Route::get('/tienda/coleccionables/{id}',
    [CatalogoPublicoController::class, 'show'])
    ->whereNumber('id');

    // Registro público de clientes
    Route::post('/cliente/registro', [
        ClienteAuthController::class, 'registro'
    ]);

    // Inicio de sesión de clientes
    Route::post('/cliente/login', [
        ClienteAuthController::class, 'login'
    ]);

    // PERFIL PROTEGIDO DEL CLIENTE
    Route::middleware('auth:api')->group(function () {

    Route::get('/cliente/perfil', [
        ClienteAuthController::class, 'perfil'
    ]);

    Route::put('/cliente/perfil', [
    ClienteAuthController::class, 'actualizarPerfil'
    ]);

    Route::post('/cliente/imagen', [
    ClienteAuthController::class, 'actualizarImagen'
    ]);

    // CAMBIAR CONTRASEÑA DEL CLIENTE
    Route::put('/cliente/password', [
    ClienteAuthController::class, 'cambiarPassword'
    ]);

    // CERRAR SESIÓN DEL CLIENTE
    Route::post('/cliente/logout', [
    ClienteAuthController::class, 'logout'
    ]);

});

Route::middleware(['auth:sanctum', 'admin.active'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('api.logout');

    $resources = [
        'administradores',
        'categorias',
        'clientes',
        'coleccionables',
        'condiciones',
        'detalles_pedidos',
        'pedidos',
        'productos',
        'proveedores',
        'universos',
        'ventas',
    ];

    Route::get('/{resource}', [ApiResourceController::class, 'index'])
        ->whereIn('resource', $resources);
    Route::post('/{resource}', [ApiResourceController::class, 'store'])
        ->whereIn('resource', $resources);
    Route::get('/{resource}/{id}', [ApiResourceController::class, 'show'])
        ->whereIn('resource', $resources)
        ->whereNumber('id');
    Route::put('/{resource}/{id}', [ApiResourceController::class, 'update'])
        ->whereIn('resource', $resources)
        ->whereNumber('id');
    Route::patch('/{resource}/{id}', [ApiResourceController::class, 'update'])
        ->whereIn('resource', $resources)
        ->whereNumber('id');
    Route::delete('/{resource}/{id}', [ApiResourceController::class, 'destroy'])
        ->whereIn('resource', $resources)
        ->whereNumber('id');
});
