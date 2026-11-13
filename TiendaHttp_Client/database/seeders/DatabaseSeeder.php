<?php

namespace Database\Seeders;

use App\Models\Administrador;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear Administrador Inicial
        Administrador::create([
            'nombre'   => 'Administrador Principal',
            'email'    => 'admin@test.com',
            'password' => Hash::make('admin123'),
            'telefono' => '3312345678',
            'activo'   => true,
        ]);

        // 2. Crear Productos iniciales
        Producto::create([
            'nombre'      => 'Laptop Dell XPS 15',
            'descripcion' => 'Laptop de alto rendimiento para desarrollo.',
            'precio'      => 24999.00,
            'stock'       => 10,
            'categoria'   => 'Electrónica',
            'imagen'      => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=500',
        ]);

        Producto::create([
            'nombre'      => 'Teclado Mecánico RGB',
            'descripcion' => 'Teclado mecánico con switches táctiles.',
            'precio'      => 1299.50,
            'stock'       => 25,
            'categoria'   => 'Accesorios',
            'imagen'      => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500',
        ]);

        // 3. Crear Proveedores iniciales
        Proveedor::create([
            'nombre'    => 'Tech Supplies SA de CV',
            'empresa'   => 'Tech Supplies',
            'email'     => 'contacto@techsupplies.com',
            'telefono'  => '5598765432',
            'direccion' => 'Av. Tecnológico #100, CDMX',
        ]);

        // 4. Crear Clientes iniciales
        $cliente = Cliente::create([
            'nombre'    => 'Carlos Gómez López',
            'email'     => 'carlos@correo.com',
            'telefono'  => '3311223344',
            'direccion' => 'Calle Reforma #456, Guadalajara',
        ]);

        // 5. Crear Pedido inicial
        Pedido::create([
            'cliente_id' => $cliente->id,
            'total'      => 26298.50,
            'estado'     => 'pendiente',
            'fecha'      => now(),
        ]);
    }
}
