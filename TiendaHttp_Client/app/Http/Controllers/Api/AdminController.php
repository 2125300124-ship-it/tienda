<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Listar administradores.
     */
    public function index()
    {
        $admins = Administrador::select('id', 'nombre', 'email', 'telefono', 'activo', 'created_at')->get();

        return response()->json([
            'status' => 'success',
            'data'   => $admins,
        ]);
    }

    /**
     * Crear un nuevo administrador.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|unique:administradores,email',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'activo'   => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['activo'] = $validated['activo'] ?? true;

        $admin = Administrador::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Administrador creado exitosamente.',
            'data'    => $admin,
        ], 201);
    }

    /**
     * Consultar un administrador por ID.
     */
    public function show($id)
    {
        $admin = Administrador::find($id);

        if (!$admin) {
            return response()->json(['status' => 'error', 'message' => 'Administrador no encontrado.'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $admin]);
    }

    /**
     * Editar / Actualizar un administrador.
     */
    public function update(Request $request, $id)
    {
        $admin = Administrador::find($id);

        if (!$admin) {
            return response()->json(['status' => 'error', 'message' => 'Administrador no encontrado.'], 404);
        }

        $validated = $request->validate([
            'nombre'   => 'sometimes|string|max:255',
            'email'    => 'sometimes|email|unique:administradores,email,' . $id,
            'password' => 'nullable|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'activo'   => 'nullable|boolean',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Administrador actualizado correctamente.',
            'data'    => $admin,
        ]);
    }

    /**
     * Eliminar un administrador.
     */
    public function destroy($id)
    {
        $admin = Administrador::find($id);

        if (!$admin) {
            return response()->json(['status' => 'error', 'message' => 'Administrador no encontrado.'], 404);
        }

        $admin->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Administrador eliminado correctamente.',
        ]);
    }
}
