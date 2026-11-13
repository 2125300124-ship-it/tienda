<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Listar todos los pedidos (con datos del cliente).
     */
    public function index()
    {
        $pedidos = Pedido::with('cliente')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $pedidos,
        ]);
    }

    /**
     * Crear un nuevo pedido.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'total'      => 'required|numeric|min:0',
            'estado'     => 'nullable|string|in:pendiente,completado,cancelado',
            'fecha'      => 'nullable|date',
        ]);

        $validated['estado'] = $validated['estado'] ?? 'pendiente';
        $validated['fecha'] = $validated['fecha'] ?? now();

        $pedido = Pedido::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Pedido registrado exitosamente.',
            'data'    => $pedido->load('cliente'),
        ], 201);
    }

    /**
     * Consultar un pedido específico por ID.
     */
    public function show($id)
    {
        $pedido = Pedido::with('cliente')->find($id);

        if (!$pedido) {
            return response()->json(['status' => 'error', 'message' => 'Pedido no encontrado.'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $pedido,
        ]);
    }

    /**
     * Eliminar un pedido.
     */
    public function destroy($id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json(['status' => 'error', 'message' => 'Pedido no encontrado.'], 404);
        }

        $pedido->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Pedido eliminado correctamente.',
        ]);
    }
}
