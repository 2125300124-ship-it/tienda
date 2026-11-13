<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Fakestoreapicontroller extends Controller
{
    //Muestra la vista del catálogo consumiendo el listado general de la API.

    public function catalogo()
    {
        try {
            $response = Http::withoutVerifying()->timeout(15)->get('https://fakestoreapi.com/products');

            if ($response->successful()) {
                $products = $response->json();
            } else {
                $products = [];
            }
        } catch (\Exception $e) {
            Log::error('Error al conectar con FakeStore API: ' . $e->getMessage());
            $products = [];
        }

        return view('Catalogo.index', compact('products'));
    }

    //Muestra la vista de detalle consumiendo un producto específico por su ID.
   
    public function detalle(int $id)
    {
        try {
            $response = Http::withoutVerifying()->timeout(15)->get("https://fakestoreapi.com/products/{$id}");

            if (!$response->successful() || empty($response->json())) {
                abort(404, 'Producto no encontrado en la API');
            }

            $product = $response->json();
            $comments = Comentario::query()
                ->where('producto_id', $id)
                ->latest()
                ->get();

            return view('Catalogo.producto', compact('product', 'comments'));
        } catch (\Exception $e) {
            Log::error("Error al obtener detalle del producto {$id}: " . $e->getMessage());
            abort(404, 'No se pudo obtener la información del producto: ' . $e->getMessage());
        }
    }

    /**
     * Endpoint API JSON que retorna el listado de productos.
     */
    public function productos()
    {
        try {
            $response = Http::withoutVerifying()->timeout(15)->get('https://fakestoreapi.com/products');

            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json(['error' => 'No fue posible consultar la API de productos: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Endpoint API JSON que retorna un producto por su ID.
     */
    public function productoById(int $id)
    {
        try {
            $response = Http::withoutVerifying()->timeout(15)->get("https://fakestoreapi.com/products/{$id}");

            if ($response->successful() && !empty($response->json())) {
                return response()->json($response->json(), 200);
            }

            return response()->json(['error' => 'Producto no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al consultar el producto: ' . $e->getMessage()], 500);
        }
    }
}
