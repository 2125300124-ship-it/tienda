<?php

use App\Http\Controllers\ClienteHttpController;
use App\Http\Controllers\CarritoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TiendaController;

// Página de inicio
Route::view('/', 'inicio')->name('inicio');

// Página nosotros
Route::view('/nosotros', 'nosotros')->name('nosotros');


Route::get('/catalogo', [TiendaController::class, 'catalogo'])
    ->name('catalogo');

Route::get('/producto/{id}', [TiendaController::class, 'detalle'])
    ->whereNumber('id')
    ->name('detalle');

// Página de contacto
Route::view('/contacto', 'contacto')->name('contacto');


 // Mostrar carrito
Route::get('/carrito', [CarritoController::class, 'index'])
    ->name('carrito.index');

// Agregar producto
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])
    ->name('carrito.agregar');

// Actualizar cantidad
Route::patch('/carrito/{id}', [CarritoController::class, 'actualizar'])
    ->whereNumber('id')
    ->name('carrito.actualizar');

// Eliminar un producto
Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])
    ->whereNumber('id')
    ->name('carrito.eliminar');

// Vaciar todo el carrito
Route::delete('/carrito', [CarritoController::class, 'vaciar'])
    ->name('carrito.vaciar');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN DE CLIENTES
|--------------------------------------------------------------------------
*/

// Mostrar registro
Route::get('/registro', [
    ClienteHttpController::class, 'mostrarRegistro'
])->name('cliente.registro');

// Procesar registro
Route::post('/registro', [
    ClienteHttpController::class, 'registro'
])->name('cliente.registro.guardar');

// Mostrar login
Route::get('/login', [
    ClienteHttpController::class, 'mostrarLogin'
])->name('cliente.login');

// Procesar login
Route::post('/login', [
    ClienteHttpController::class, 'login'
])->name('cliente.login.procesar');

// Consultar perfil del cliente
Route::get('/perfil', [
    ClienteHttpController::class, 'perfil'
])->name('cliente.perfil');

Route::put('/perfil', [
    ClienteHttpController::class, 'actualizarPerfil'
])->name('cliente.perfil.actualizar');

Route::post('/perfil/imagen', [
    ClienteHttpController::class, 'actualizarImagen'
])->name('cliente.perfil.imagen');

Route::put('/perfil/password', [
    ClienteHttpController::class, 'cambiarPassword'
])->name('cliente.perfil.password');

// Cerrar sesión del cliente
Route::post('/logout', [
    ClienteHttpController::class, 'logout'
])->name('cliente.logout');