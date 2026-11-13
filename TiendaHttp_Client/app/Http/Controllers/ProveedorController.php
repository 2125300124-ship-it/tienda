<?php

namespace App\Http\Controllers;

class ProveedorController extends BaseHttpResourceController
{
    protected string $resource = 'proveedores';
    protected string $module = 'proveedores';
    protected string $moduleTitle = 'Proveedores';
    protected string $modelName = 'Proveedor';

    protected array $fields = [
        ['name' => 'nombre_empresa', 'label' => 'Empresa', 'required' => true],
        ['name' => 'contacto', 'label' => 'Contacto', 'required' => true],
        ['name' => 'correo', 'label' => 'Correo', 'type' => 'email', 'required' => true],
        ['name' => 'telefono', 'label' => 'Teléfono', 'required' => true],
        ['name' => 'direccion', 'label' => 'Dirección', 'required' => true],
        ['name' => 'ciudad', 'label' => 'Ciudad', 'required' => true],
        ['name' => 'estado', 'label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => ['1' => 'Activo', '0' => 'Inactivo']],
        ['name' => 'imagen', 'label' => 'Imagen', 'type' => 'image', 'required' => true],
    ];
}
