<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data'   => Cliente::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:255',
            'email'     => 'required|email|unique:clientes,email',
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ]);

        $cliente = Cliente::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Cliente registrado exitosamente.',
            'data'    => $cliente,
        ], 201);
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['status' => 'error', 'message' => 'Cliente no encontrado.'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $cliente]);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['status' => 'error', 'message' => 'Cliente no encontrado.'], 404);
        }

        $validated = $request->validate([
            'nombre'    => 'sometimes|string|max:255',
            'email'     => 'sometimes|email|unique:clientes,email,' . $id,
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ]);

        $cliente->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Cliente actualizado correctamente.',
            'data'    => $cliente,
        ]);
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['status' => 'error', 'message' => 'Cliente no encontrado.'], 404);
        }

        $cliente->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Cliente eliminado correctamente.',
        ]);
    }
}
