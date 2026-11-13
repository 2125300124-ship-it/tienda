<?php

namespace App\Http\Controllers;

class ProductoController extends BaseHttpResourceController
{
    protected string $resource = 'productos';
    protected string $module = 'productos';
    protected string $moduleTitle = 'Productos';
    protected string $modelName = 'Producto';

    protected array $fields = [
        ['name' => 'categoria_id', 'label' => 'Categoría', 'type' => 'select', 'required' => true],
        ['name' => 'proveedor_id', 'label' => 'Proveedor', 'type' => 'select', 'required' => true],
        ['name' => 'nombre', 'label' => 'Nombre', 'required' => true],
        ['name' => 'descripcion', 'label' => 'Descripción', 'type' => 'textarea', 'required' => true],
        ['name' => 'precio', 'label' => 'Precio', 'type' => 'number', 'required' => true],
        ['name' => 'existencia', 'label' => 'Existencia', 'type' => 'number', 'required' => true],
        ['name' => 'marca', 'label' => 'Marca', 'required' => true],
        ['name' => 'estado', 'label' => 'Estado', 'type' => 'select', 'required' => true, 'options' => ['1' => 'Activo', '0' => 'Inactivo']],
        ['name' => 'imagen', 'label' => 'Imagen principal', 'type' => 'image', 'required' => true],
        ['name' => 'imagen2', 'label' => 'Segunda imagen', 'type' => 'image', 'required' => false],
        ['name' => 'imagen3', 'label' => 'Tercera imagen', 'type' => 'image', 'required' => false],
    ];

    protected array $optionSources = [
        'categoria_id' => ['resource' => 'categorias', 'label' => 'nombre'],
        'proveedor_id' => ['resource' => 'proveedores', 'label' => 'nombre_empresa'],
    ];
}
