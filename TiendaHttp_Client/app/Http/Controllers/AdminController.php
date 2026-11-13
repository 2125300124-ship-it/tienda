<?php

namespace App\Http\Controllers;

class AdminController extends BaseHttpResourceController
{
    protected string $resource = 'administradores';
    protected string $module = 'administradores';
    protected string $moduleTitle = 'Administradores';
    protected string $modelName = 'Administrador';

    protected array $fields = [
        ['name' => 'nombres', 'label' => 'Nombres', 'required' => true],
        ['name' => 'apellidos', 'label' => 'Apellidos', 'required' => true],
        ['name' => 'correo', 'label' => 'Correo', 'type' => 'email', 'required' => true],
        ['name' => 'usuario', 'label' => 'Usuario', 'required' => true],
        ['name' => 'contrasena', 'column' => 'contraseña', 'label' => 'Contraseña', 'type' => 'password', 'required' => true],
        ['name' => 'rol', 'label' => 'Rol', 'type' => 'select', 'required' => true, 'options' => ['Dueño' => 'Dueño', 'Inventario' => 'Inventario', 'Ventas' => 'Ventas']],
        ['name' => 'estado', 'label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => ['1' => 'Activo', '0' => 'Inactivo']],
        ['name' => 'imagen', 'label' => 'Imagen', 'type' => 'image'],
    ];
}
