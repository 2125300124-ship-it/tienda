<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = ['Figuras', 'Cartas', 'Ropa'];

        foreach ($categorias as $nombre) {
            DB::table('categorias')->updateOrInsert(
                ['nombre' => $nombre],
                ['nombre' => $nombre, 'estado' => 1, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
