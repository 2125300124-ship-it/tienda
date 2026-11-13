<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, int $producto): RedirectResponse
    {
        $validated = $request->validate([
            'autor' => 'required|string|max:100',
            'contenido' => 'required|string|max:2000',
        ]);

        Comentario::create([
            ...$validated,
            'producto_id' => $producto,
        ]);

        return redirect()
            ->route('catalogo.producto', $producto)
            ->with('success', 'Comentario agregado correctamente.');
    }

    public function update(Request $request, int $producto, int $comentario): RedirectResponse
    {
        $comentario = $this->comentarioDelProducto($producto, $comentario);

        $validated = $request->validate([
            'contenido' => 'required|string|max:2000',
        ]);

        $comentario->update($validated);

        return redirect()
            ->route('catalogo.producto', $producto)
            ->with('success', 'Comentario actualizado correctamente.');
    }

    public function destroy(int $producto, int $comentario): RedirectResponse
    {
        $this->comentarioDelProducto($producto, $comentario)->delete();

        return redirect()
            ->route('catalogo.producto', $producto)
            ->with('success', 'Comentario eliminado correctamente.');
    }

    private function comentarioDelProducto(int $producto, int $comentario): Comentario
    {
        return Comentario::query()
            ->where('producto_id', $producto)
            ->findOrFail($comentario);
    }
}
