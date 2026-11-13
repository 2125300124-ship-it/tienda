<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data'   => Proveedor::latest()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'    => 'required|string|max:255',
            'empresa'   => 'nullable|string|max:255',
            'email'     => 'required|email|unique:proveedores,email',
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ]);

        $proveedor = Proveedor::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Proveedor registrado exitosamente.',
            'data'    => $proveedor,
        ], 201);
    }

    public function show($id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['status' => 'error', 'message' => 'Proveedor no encontrado.'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $proveedor]);
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['status' => 'error', 'message' => 'Proveedor no encontrado.'], 404);
        }

        $validated = $request->validate([
            'nombre'    => 'sometimes|string|max:255',
            'empresa'   => 'nullable|string|max:255',
            'email'     => 'sometimes|email|unique:proveedores,email,' . $id,
            'telefono'  => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
        ]);

        $proveedor->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Proveedor actualizado correctamente.',
            'data'    => $proveedor,
        ]);
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);

        if (!$proveedor) {
            return response()->json(['status' => 'error', 'message' => 'Proveedor no encontrado.'], 404);
        }

        $proveedor->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Proveedor eliminado correctamente.',
        ]);
    }
}
