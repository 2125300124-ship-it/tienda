
<?php

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
