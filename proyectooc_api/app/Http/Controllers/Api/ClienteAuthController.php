<?php

namespace App\Http\Controllers\Api;

use App\Services\CloudinaryImageStorage;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ClienteAuthController extends Controller
{
    // REGISTRO DE CLIENTES
    public function registro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:clientes,correo',
            'telefono' => 'nullable|string|max:20',
            'contraseña' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers(),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Los datos proporcionados no son válidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $datos = $validator->validated();

        $cliente = Cliente::create([
            'nombres' => $datos['nombres'],
            'apellidos' => $datos['apellidos'],
            'correo' => $datos['correo'],
            'telefono' => $datos['telefono'] ?? null,
            'contraseña' => Hash::make($datos['contraseña']),
            'estado' => 1,
        ]);

        $token = $cliente->createToken('collector-store')->plainTextToken;

        return response()->json([
            'message' => 'Cliente registrado correctamente.',
            'cliente' => $cliente,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    // INICIO DE SESIÓN
    public function login(Request $request)
    {
        $datos = $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required|string',
        ]);

        $cliente = Cliente::where('correo', $datos['correo'])
            ->first();

        if (
            !$cliente ||
            !Hash::check($datos['contraseña'], $cliente->contraseña)
        ) {
            return response()->json([
                'message' => 'Correo o contraseña incorrectos.',
            ], 401);
        }

        if (!$cliente->estado) {
            return response()->json([
                'message' => 'La cuenta está desactivada.',
            ], 403);
        }

        $token = $cliente->createToken('collector-store')->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso.',
            'cliente' => $cliente,
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // CONSULTAR PERFIL DEL CLIENTE
    public function perfil(
        Request $request,
        CloudinaryImageStorage $cloudinary
    ) {
        $cliente = $request->user('api');

        $datos = $cliente->toArray();

        $datos['imagen'] = $cloudinary->url($cliente->imagen);

        return response()->json([
            'message' => 'Perfil obtenido correctamente.',
            'cliente' => $datos,
        ]);
    }


    // ACTUALIZAR DATOS PERSONALES
    public function actualizarPerfil(Request $request)
    {
        $cliente = $request->user('api');

        $datos = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => [
                'required',
                'email',
                Rule::unique('clientes', 'correo')->ignore($cliente->id),
            ],
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        $cliente->update($datos);

        return response()->json([
            'message' => 'Perfil actualizado correctamente.',
            'cliente' => $cliente->fresh(),
        ]);
    }


    // SUBIR O CAMBIAR FOTOGRAFÍA DE PERFIL
    public function actualizarImagen(
        Request $request,
        CloudinaryImageStorage $cloudinary
    ) {
        $cliente = $request->user('api');

        $request->validate([
            'imagen' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $imagenAnterior = $cliente->imagen;

        try {
            // Subir imagen a Cloudinary
            $nuevaImagen = $cloudinary->upload(
                $request->file('imagen'),
                'collector-store/clientes'
            );

            // Guardar referencia en MySQL
            $cliente->imagen = $nuevaImagen;
            $cliente->save();

            // Eliminar imagen anterior de Cloudinary
            if ($imagenAnterior) {
                try {
                    $cloudinary->delete($imagenAnterior);
                } catch (\Throwable $e) {
                    \Log::warning(
                        'No se pudo eliminar la fotografía anterior del cliente.',
                        ['cliente_id' => $cliente->id]
                    );
                }
            }

            return response()->json([
                'message' => 'Fotografía actualizada correctamente.',
                'cliente' => [
                    'id' => $cliente->id,
                    'nombres' => $cliente->nombres,
                    'apellidos' => $cliente->apellidos,
                    'correo' => $cliente->correo,
                    'telefono' => $cliente->telefono,
                    'direccion' => $cliente->direccion,
                    'imagen' => $cloudinary->url($cliente->imagen),
                ],
            ]);

        } catch (\Throwable $e) {
            \Log::error(
                'Error al actualizar la fotografía de perfil.',
                ['cliente_id' => $cliente->id]
            );

            return response()->json([
                'message' => 'No se pudo actualizar la fotografía.',
            ], 500);
        }
    }


    // CAMBIAR CONTRASEÑA DEL CLIENTE
    public function cambiarPassword(Request $request)
    {
        $cliente = $request->user('api');

        $datos = $request->validate([
            'password_actual' => [
                'required',
                'string',
            ],
            'password_nuevo' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers(),
            ],
        ]);

        // Verificar contraseña actual
        if (!Hash::check(
            $datos['password_actual'],
            $cliente->contraseña
        )) {
            return response()->json([
                'message' => 'La contraseña actual es incorrecta.',
                'errors' => [
                    'password_actual' => [
                        'La contraseña actual es incorrecta.'
                    ]
                ]
            ], 422);
        }

        // Evitar reutilizar la misma contraseña
        if (Hash::check(
            $datos['password_nuevo'],
            $cliente->contraseña
        )) {
            return response()->json([
                'message' => 'Debes elegir una contraseña diferente.',
                'errors' => [
                    'password_nuevo' => [
                        'La nueva contraseña debe ser diferente de la actual.'
                    ]
                ]
            ], 422);
        }

        // Guardar nueva contraseña de forma segura
        $cliente->contraseña = Hash::make(
            $datos['password_nuevo']
        );

        $cliente->save();

        return response()->json([
            'message' => 'Contraseña actualizada correctamente.'
        ]);
    }


    // CERRAR SESIÓN DEL CLIENTE
    public function logout(Request $request)
    {
        $cliente = $request->user('api');

        // Revocar el token utilizado para esta sesión
        $cliente->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente.'
        ]);
    }


}
