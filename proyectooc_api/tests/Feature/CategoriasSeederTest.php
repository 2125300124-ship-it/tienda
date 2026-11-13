<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriasSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_categories_available_for_products(): void
    {
        $this->seed();

        $this->assertDatabaseHas('categorias', ['nombre' => 'Figuras', 'estado' => true]);
        $this->assertDatabaseHas('categorias', ['nombre' => 'Cartas', 'estado' => true]);
        $this->assertDatabaseHas('categorias', ['nombre' => 'Ropa', 'estado' => true]);
    }
}
