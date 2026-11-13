<?php

namespace Tests\Feature;

use App\Models\Comentario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ComentarioTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_comment_can_be_created_for_a_product(): void
    {
        $response = $this->post(route('catalogo.comentarios.store', 1), [
            'autor' => 'Ana',
            'contenido' => 'Muy buen producto.',
        ]);

        $response->assertRedirect(route('catalogo.producto', 1));
        $this->assertDatabaseHas('comentarios', [
            'producto_id' => 1,
            'autor' => 'Ana',
            'contenido' => 'Muy buen producto.',
        ]);
    }

    public function test_a_comment_can_be_updated_and_deleted(): void
    {
        $comment = Comentario::create([
            'producto_id' => 1,
            'autor' => 'Ana',
            'contenido' => 'Comentario inicial.',
        ]);

        $this->put(route('catalogo.comentarios.update', [1, $comment->id]), [
            'contenido' => 'Comentario actualizado.',
        ])->assertRedirect(route('catalogo.producto', 1));

        $this->assertDatabaseHas('comentarios', [
            'id' => $comment->id,
            'contenido' => 'Comentario actualizado.',
        ]);

        $this->delete(route('catalogo.comentarios.destroy', [1, $comment->id]))
            ->assertRedirect(route('catalogo.producto', 1));

        $this->assertDatabaseMissing('comentarios', ['id' => $comment->id]);
    }

    public function test_a_comment_cannot_be_changed_through_another_product(): void
    {
        $comment = Comentario::create([
            'producto_id' => 1,
            'autor' => 'Ana',
            'contenido' => 'Comentario.',
        ]);

        $this->put(route('catalogo.comentarios.update', [2, $comment->id]), [
            'contenido' => 'Texto manipulado.',
        ])->assertNotFound();

        $this->delete(route('catalogo.comentarios.destroy', [2, $comment->id]))
            ->assertNotFound();

        $this->assertDatabaseHas('comentarios', [
            'id' => $comment->id,
            'contenido' => 'Comentario.',
        ]);
    }

    public function test_a_comment_requires_a_name_and_content(): void
    {
        $this->from('/')->post(route('catalogo.comentarios.store', 1), [
            'autor' => '',
            'contenido' => '',
        ])->assertRedirect('/')
            ->assertSessionHasErrors(['autor', 'contenido']);
    }

    public function test_product_detail_displays_only_its_comments(): void
    {
        Http::fake([
            'https://fakestoreapi.com/products/1' => Http::response([
                'id' => 1,
                'title' => 'Producto de prueba',
                'price' => 10,
                'description' => 'Descripción',
                'category' => 'Pruebas',
                'image' => 'https://example.com/product.png',
                'rating' => ['rate' => 4, 'count' => 1],
            ]),
        ]);

        Comentario::create([
            'producto_id' => 1,
            'autor' => 'Ana',
            'contenido' => 'Comentario visible.',
        ]);
        Comentario::create([
            'producto_id' => 2,
            'autor' => 'Luis',
            'contenido' => 'Comentario de otro producto.',
        ]);

        $this->get(route('catalogo.producto', 1))
            ->assertOk()
            ->assertSee('Comentario visible.')
            ->assertDontSee('Comentario de otro producto.');
    }
}
