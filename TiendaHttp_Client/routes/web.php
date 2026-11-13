<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\Fakestoreapicontroller;

// Redirección principal hacia el Área Administrativa
Route::get('/', function () {
    return session()->has('admin_token')
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('inicio');

// Catálogo FakeStore (actividad anterior disponible en /catalogo)
Route::get('/catalogo', [Fakestoreapicontroller::class, 'catalogo'])->name('catalogo.index');
Route::get('/catalogo/producto/{id}', [Fakestoreapicontroller::class, 'detalle'])->name('catalogo.producto')->whereNumber('id');

// Autenticación de Administradores
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Área Administrativa protegida por Token Sanctum
Route::middleware('admin.token')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Administradores
    Route::get('/administradores', [AdminController::class, 'listar'])->name('administradores.listar');
    Route::get('/administradores/crear', [AdminController::class, 'vistaFormulario'])->name('administradores.formulario');
    Route::post('/administradores/guardar', [AdminController::class, 'registrar'])->name('administradores.registrar');
    Route::get('/administradores/editar/{id}', [AdminController::class, 'vistaEdicion'])->name('administradores.edicion');
    Route::match(['put', 'patch'], '/administradores/actualizar/{id}', [AdminController::class, 'actualizar'])->name('administradores.actualizar');
    Route::get('/administradores/mostrar/{id}', [AdminController::class, 'vistaMostrar'])->name('administradores.mostrar');
    Route::delete('/administradores/borrar/{id}', [AdminController::class, 'borrar'])->name('administradores.borrar');

    // Productos
    Route::get('/productos', [ProductoController::class, 'listar'])->name('productos.listar');
    Route::get('/productos/crear', [ProductoController::class, 'vistaFormulario'])->name('productos.formulario');
    Route::post('/productos/guardar', [ProductoController::class, 'registrar'])->name('productos.registrar');
    Route::get('/productos/editar/{id}', [ProductoController::class, 'vistaEdicion'])->name('productos.edicion');
    Route::match(['put', 'patch'], '/productos/actualizar/{id}', [ProductoController::class, 'actualizar'])->name('productos.actualizar');
    Route::get('/productos/mostrar/{id}', [ProductoController::class, 'vistaMostrar'])->name('productos.mostrar');
    Route::delete('/productos/borrar/{id}', [ProductoController::class, 'borrar'])->name('productos.borrar');

    // Proveedores
    Route::get('/proveedores', [ProveedorController::class, 'listar'])->name('proveedores.listar');
    Route::get('/proveedores/crear', [ProveedorController::class, 'vistaFormulario'])->name('proveedores.formulario');
    Route::post('/proveedores/guardar', [ProveedorController::class, 'registrar'])->name('proveedores.registrar');
    Route::get('/proveedores/editar/{id}', [ProveedorController::class, 'vistaEdicion'])->name('proveedores.edicion');
    Route::match(['put', 'patch'], '/proveedores/actualizar/{id}', [ProveedorController::class, 'actualizar'])->name('proveedores.actualizar');
    Route::get('/proveedores/mostrar/{id}', [ProveedorController::class, 'vistaMostrar'])->name('proveedores.mostrar');
    Route::delete('/proveedores/borrar/{id}', [ProveedorController::class, 'borrar'])->name('proveedores.borrar');

    // Clientes
    Route::get('/clientes', [ClienteController::class, 'listar'])->name('clientes.listar');
    Route::get('/clientes/crear', [ClienteController::class, 'vistaFormulario'])->name('clientes.formulario');
    Route::post('/clientes/guardar', [ClienteController::class, 'registrar'])->name('clientes.registrar');
    Route::get('/clientes/editar/{id}', [ClienteController::class, 'vistaEdicion'])->name('clientes.edicion');
    Route::match(['put', 'patch'], '/clientes/actualizar/{id}', [ClienteController::class, 'actualizar'])->name('clientes.actualizar');
    Route::get('/clientes/mostrar/{id}', [ClienteController::class, 'vistaMostrar'])->name('clientes.mostrar');
    Route::delete('/clientes/borrar/{id}', [ClienteController::class, 'borrar'])->name('clientes.borrar');

    // Pedidos
    Route::get('/pedidos', [PedidoController::class, 'listar'])->name('pedidos.listar');
    Route::get('/pedidos/mostrar/{id}', [PedidoController::class, 'vistaMostrar'])->name('pedidos.mostrar');
    Route::delete('/pedidos/borrar/{id}', [PedidoController::class, 'borrar'])->name('pedidos.borrar');
});
