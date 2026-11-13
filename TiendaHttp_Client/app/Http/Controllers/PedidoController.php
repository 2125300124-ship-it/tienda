<?php

namespace App\Http\Controllers;

class PedidoController extends BaseHttpResourceController
{
    protected string $resource = 'pedidos';
    protected string $module = 'pedidos';
    protected string $moduleTitle = 'Pedidos';
    protected string $modelName = 'Pedido';

    protected array $fields = [
        ['name' => 'cliente_id', 'label' => 'Cliente', 'type' => 'select', 'required' => true],
        ['name' => 'fecha', 'label' => 'Fecha', 'type' => 'date', 'required' => true],
        ['name' => 'iva', 'label' => 'IVA', 'type' => 'number', 'required' => true],
        ['name' => 'descuento', 'label' => 'Descuento', 'type' => 'number'],
        ['name' => 'total', 'label' => 'Total', 'type' => 'number', 'required' => true],
        ['name' => 'estado', 'label' => 'Estado', 'type' => 'select', 'options' => ['Pendiente' => 'Pendiente', 'Pagado' => 'Pagado', 'Cancelado' => 'Cancelado']],
    ];

    protected array $optionSources = [
        'cliente_id' => ['resource' => 'clientes', 'label' => 'nombres'],
    ];
}
