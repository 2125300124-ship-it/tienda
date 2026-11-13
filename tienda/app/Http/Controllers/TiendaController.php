<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TiendaController extends Controller
{
    private function apiUrl(): string
    {
        return rtrim(config('services.tienda_api_url'), '/');
    }

    public function catalogo(): View
    {
        $productos = [];
        $error = null;

        try {
            $respuesta = Http::acceptJson()
                ->timeout(10)
                ->get($this->apiUrl() . '/tienda/coleccionables');

            if ($respuesta->successful()) {
                $productos = $respuesta->json('data') ?? [];

                if (!is_array($productos)) {
                    $productos = [];
                    $error = 'La API devolvió un formato inesperado.';
                }
            } else {
                $error = 'No fue posible cargar el catálogo (HTTP '
                    . $respuesta->status() . ').';
            }
        } catch (\Throwable $e) {
            Log::warning('Error al cargar catálogo público: ' . $e->getMessage());

            $error = 'No se pudo conectar con la API. Comprueba que esté encendida.';
        }

        return view('catalogo', compact('productos', 'error'));
    }

    public function detalle(int $id): View
    {
        $producto = null;
        $error = null;

        try {
            $respuesta = Http::acceptJson()
                ->timeout(10)
                ->get($this->apiUrl() . '/tienda/coleccionables/' . $id);

            if ($respuesta->successful()) {
                $producto = $respuesta->json('data');
            } elseif ($respuesta->status() === 404) {
                abort(404, 'Producto no encontrado');
            } else {
                $error = 'No fue posible cargar el detalle (HTTP '
                    . $respuesta->status() . ').';
            }
        } catch (\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::warning('Error al cargar detalle público: ' . $e->getMessage());

            $error = 'No se pudo conectar con la API. Comprueba que esté encendida.';
        }

        return view('detalle', compact('producto', 'error', 'id'));
    }
}
