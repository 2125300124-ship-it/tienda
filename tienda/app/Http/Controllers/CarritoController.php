<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{
    // Consultar producto desde la API
    private function obtenerProducto($id)
    {
        try {
            $url = rtrim(config('services.tienda_api_url'), '/');

            $respuesta = Http::acceptJson()
                ->timeout(10)
                ->get($url . '/tienda/coleccionables/' . $id);

            if ($respuesta->successful()) {
                return $respuesta->json('data');
            }
        } catch (\Throwable $e) {
            Log::warning($e->getMessage());
        }

        return null;
    }

    // Mostrar el carrito
    public function index(Request $request)
    {
        $carrito = $request->session()->get('carrito', []);

        $total = 0;

        foreach ($carrito as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }

        return view('carrito', compact('carrito', 'total'));
    }

    // Agregar producto
    public function agregar(Request $request)
    {
        $datos = $request->validate([
            'id' => 'required|integer|min:1',
            'cantidad' => 'required|integer|min:1',
        ]);

        $producto = $this->obtenerProducto($datos['id']);

        if (!$producto) {
            return back()->with('error', 'No se pudo obtener el producto.');
        }

        $id = $producto['id'];
        $existencia = (int) ($producto['existencia'] ?? 0);

        $carrito = $request->session()->get('carrito', []);

        $cantidadActual = $carrito[$id]['cantidad'] ?? 0;
        $nuevaCantidad = $cantidadActual + $datos['cantidad'];

        if ($existencia <= 0 || $nuevaCantidad > $existencia) {
            return back()->with('error', 'No hay suficientes unidades disponibles.');
        }

        $carrito[$id] = [
            'id' => $id,
            'nombre' => $producto['nombre'],
            'precio' => (float) $producto['precio'],
            'imagen' => $producto['imagen1'] ?? null,
            'cantidad' => $nuevaCantidad,
            'existencia' => $existencia,
        ];

        $request->session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')
            ->with('success', 'Producto agregado correctamente.');
    }

    // Actualizar cantidad
    public function actualizar(Request $request, $id)
    {
        $datos = $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $carrito = $request->session()->get('carrito', []);

        if (!isset($carrito[$id])) {
            return back()->with('error', 'Producto no encontrado en el carrito.');
        }

        $producto = $this->obtenerProducto($id);

        if (!$producto) {
            return back()->with('error', 'No se pudo verificar el producto.');
        }

        $existencia = (int) ($producto['existencia'] ?? 0);

        if ($datos['cantidad'] > $existencia) {
            return back()->with('error', 'La cantidad supera la existencia disponible.');
        }

        $carrito[$id]['cantidad'] = $datos['cantidad'];
        $carrito[$id]['precio'] = (float) $producto['precio'];
        $carrito[$id]['existencia'] = $existencia;

        $request->session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')
            ->with('success', 'Cantidad actualizada.');
    }

    // Eliminar producto
    public function eliminar(Request $request, $id)
    {
        $carrito = $request->session()->get('carrito', []);

        unset($carrito[$id]);

        $request->session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')
            ->with('success', 'Producto eliminado.');
    }

    // Vaciar carrito
    public function vaciar(Request $request)
    {
        $request->session()->forget('carrito');

        return redirect()->route('carrito.index')
            ->with('success', 'Carrito vaciado correctamente.');
    }
}
