<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Services\CloudinaryImageStorage;
use Illuminate\Http\JsonResponse;

class CatalogoPublicoController extends Controller
{
    public function index(CloudinaryImageStorage $imagenes): JsonResponse
    {
        $productos = Producto::where('estado', 1)
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'data' => $productos->map(
                fn ($producto) => $this->formato($producto, $imagenes)
            )->values()
        ]);
    }

    public function show(int $id, CloudinaryImageStorage $imagenes): JsonResponse
    {
        $producto = Producto::where('estado', 1)
            ->findOrFail($id);

        return response()->json([
            'data' => $this->formato($producto, $imagenes)
        ]);
    }

    private function formato(Producto $producto, CloudinaryImageStorage $imagenes): array
    {
        return [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'precio' => $producto->precio,
            'existencia' => $producto->existencia,
            'marca' => $producto->marca,
            'imagen1' => $imagenes->url($producto->imagen),
            'imagen2' => $imagenes->url($producto->imagen2),
            'imagen3' => $imagenes->url($producto->imagen3),
        ];
    }
}
