
<?php

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
