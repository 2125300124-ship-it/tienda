<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    private string $endpoint = 'http://127.0.0.1:8000/api';

    /**
     * Iniciar sesión como Administrador y generar token Sanctum.
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $response = Http::asJson()
                ->timeout(10)
                ->post($this->endpoint . '/login', $validated);
        } catch (ConnectionException $exception) {
            Log::warning('No fue posible conectar con el servicio de autenticación.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'No fue posible conectar con el servicio de autenticación.',
            ], 502);
        }

        $credenciales = $response->json();
        if (!$response->successful()) {
            return response()->json(
                is_array($credenciales) ? $credenciales : [
                    'status'  => 'error',
                    'message' => 'No fue posible autenticar al administrador.',
                ],
                $response->status()
            );
        }

        if (!is_array($credenciales) || empty($credenciales['token'])) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No se recibió un token válido del servicio de autenticación.',
            ], 502);
        }

        return response()->json($credenciales, $response->status());
    }

    /**
     * Cerrar sesión y revocar el token activo.
     */
    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No se recibió un token para cerrar sesión.',
            ], 401);
        }

        try {
            $response = Http::withToken($token)
                ->timeout(10)
                ->post($this->endpoint . '/logout');
        } catch (ConnectionException $exception) {
            Log::warning('No fue posible conectar con el servicio de autenticación.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'No fue posible conectar con el servicio de autenticación.',
            ], 502);
        }

        return response()->json(
            $response->json() ?? [
                'status'  => $response->successful() ? 'success' : 'error',
                'message' => $response->successful()
                    ? 'Sesión cerrada exitosamente.'
                    : 'No fue posible cerrar sesión en el servicio de autenticación.',
            ],
            $response->status()
        );
    }

    /**
     * Obtener el perfil del administrador autenticado (validación de token).
     */
    public function perfil(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'admin'  => $request->user(),
        ], 200);
    }
}
