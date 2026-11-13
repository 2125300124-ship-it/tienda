<?php

namespace App\Http\Controllers;

class ClienteController extends BaseHttpResourceController
{
    protected string $resource = 'clientes';
    protected string $module = 'clientes';
    protected string $moduleTitle = 'Clientes';
    protected string $modelName = 'Cliente';

    protected array $fields = [
        ['name' => 'nombres', 'label' => 'Nombres', 'required' => true],
        ['name' => 'apellidos', 'label' => 'Apellidos', 'required' => true],
        ['name' => 'correo', 'label' => 'Correo', 'type' => 'email', 'required' => true],
        ['name' => 'contrasena', 'column' => 'contraseña', 'label' => 'Contraseña', 'type' => 'password', 'required' => true],
        ['name' => 'direccion', 'label' => 'Dirección', 'type' => 'textarea'],
        ['name' => 'estado', 'label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => ['1' => 'Activo', '0' => 'Inactivo']],
        ['name' => 'imagen', 'label' => 'Imagen', 'type' => 'image'],
    ];
}
