<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;

class ClienteHttpController extends Controller
{
    private function apiUrl(): string
    {
        return rtrim(config('services.tienda_api_url'), '/');
    }

    // Mostrar formulario de registro
    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    // Registrar cliente mediante la API
    public function registro(Request $request)
    {
        $datos = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'contraseña' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers(),
            ],
        ]);

        try {
            $respuesta = Http::acceptJson()
                ->timeout(15)
                ->post($this->apiUrl() . '/cliente/registro', $datos);

            if ($respuesta->successful()) {
                // Renovar ID de sesión al autenticar
                $request->session()->regenerate();

                // Guardar token del lado del servidor
                $request->session()->put(
                    'cliente_token',
                    $respuesta->json('token')
                );

                $request->session()->put(
                    'cliente',
                    $respuesta->json('cliente')
                );

                return redirect()->route('cliente.perfil')
                    ->with('success', 'Cuenta creada correctamente.');
            }

            if ($respuesta->status() === 422) {
                return back()
                    ->withErrors($respuesta->json('errors') ?? [])
                    ->withInput($request->except(
                        'contraseña',
                        'contraseña_confirmation'
                    ));
            }

            return back()->with(
                'error',
                'No fue posible registrar el usuario.'
            );
        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'No se pudo conectar con la API.'
            );
        }
    }

    // Mostrar formulario de login
    public function mostrarLogin()
    {
        return view('auth.login');
    }

    // Iniciar sesión mediante la API
    public function login(Request $request)
    {
        $datos = $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required|string',
        ]);

        try {
            $respuesta = Http::acceptJson()
                ->timeout(15)
                ->post($this->apiUrl() . '/cliente/login', $datos);

            if ($respuesta->successful()) {
                $request->session()->regenerate();

                $request->session()->put(
                    'cliente_token',
                    $respuesta->json('token')
                );

                $request->session()->put(
                    'cliente',
                    $respuesta->json('cliente')
                );

                return redirect()->route('cliente.perfil')
                    ->with('success', 'Bienvenido a Collector Store.');
            }

            return back()
                ->with('error', 'Correo o contraseña incorrectos.')
                ->withInput($request->only('correo'));
        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'No se pudo conectar con la API.'
            );
        }
    }


    // MOSTRAR PERFIL DEL CLIENTE
    public function perfil(Request $request)
    {
        $token = $request->session()->get('cliente_token');

        if (!$token) {
            return redirect()->route('cliente.login')
                ->with('error', 'Debes iniciar sesión.');
        }

        try {
            $respuesta = Http::withToken($token)
                ->acceptJson()
                ->timeout(15)
                ->get($this->apiUrl() . '/cliente/perfil');

            if ($respuesta->status() === 401) {
                $request->session()->forget([
                    'cliente_token',
                    'cliente'
                ]);

                return redirect()->route('cliente.login')
                    ->with('error', 'Tu sesión ha expirado.');
            }

            if (!$respuesta->successful()) {
                return redirect()->route('inicio')
                    ->with('error', 'No se pudo consultar el perfil.');
            }

            $cliente = $respuesta->json('cliente');

            $request->session()->put('cliente', $cliente);

            return view('auth.perfil', compact('cliente'));

        } catch (\Throwable $e) {
            return redirect()->route('inicio')
                ->with('error', 'No se pudo conectar con la API.');
        }
    }


    // ACTUALIZAR DATOS PERSONALES DEL CLIENTE
    public function actualizarPerfil(Request $request)
    {
        $token = $request->session()->get('cliente_token');

        if (!$token) {
            return redirect()->route('cliente.login')
                ->with('error', 'Debes iniciar sesión.');
        }

        $datos = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        try {
            $respuesta = Http::withToken($token)
                ->acceptJson()
                ->timeout(15)
                ->put($this->apiUrl() . '/cliente/perfil', $datos);

            if ($respuesta->status() === 401) {
                $request->session()->forget([
                    'cliente_token',
                    'cliente'
                ]);

                return redirect()->route('cliente.login')
                    ->with('error', 'Tu sesión ha expirado.');
            }

            if ($respuesta->status() === 422) {
                return back()
                    ->withErrors(
                        $respuesta->json('errors', [])
                    )
                    ->withInput();
            }

            if (!$respuesta->successful()) {
                return back()
                    ->with('error', 'No se pudo actualizar el perfil.')
                    ->withInput();
            }

            $request->session()->put(
                'cliente',
                $respuesta->json('cliente')
            );

            return redirect()->route('cliente.perfil')
                ->with('success', 'Datos actualizados correctamente.');

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return back()
                ->with('error', 'No se pudo conectar con la API.')
                ->withInput();
        }
    }


    // ACTUALIZAR FOTOGRAFÍA DE PERFIL
    public function actualizarImagen(Request $request)
    {
        $token = $request->session()->get('cliente_token');

        if (!$token) {
            return redirect()->route('cliente.login')
                ->with('error', 'Debes iniciar sesión.');
        }

        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        try {
            $archivo = $request->file('imagen');

            $respuesta = Http::withToken($token)
                ->acceptJson()
                ->timeout(60)
                ->attach(
                    'imagen',
                    fopen($archivo->getRealPath(), 'r'),
                    $archivo->getClientOriginalName()
                )
                ->post($this->apiUrl() . '/cliente/imagen');

            if ($respuesta->status() === 401) {
                $request->session()->forget([
                    'cliente_token',
                    'cliente'
                ]);

                return redirect()->route('cliente.login')
                    ->with('error', 'Tu sesión ha expirado.');
            }

            if ($respuesta->status() === 422) {
                return back()->withErrors(
                    $respuesta->json('errors', [])
                );
            }

            if (!$respuesta->successful()) {
                return back()
                    ->with('error', 'No se pudo actualizar la fotografía.');
            }

            $request->session()->put(
                'cliente',
                $respuesta->json('cliente')
            );

            return redirect()->route('cliente.perfil')
                ->with('success', 'Fotografía actualizada correctamente.');

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return back()
                ->with('error', 'No se pudo conectar con la API.');
        }
    }


    // CAMBIAR CONTRASEÑA DEL CLIENTE
    public function cambiarPassword(Request $request)
    {
        $token = $request->session()->get('cliente_token');

        if (!$token) {
            return redirect()->route('cliente.login')
                ->with('error', 'Debes iniciar sesión.');
        }


        $datos = $request->validate([
            'password_actual' => 'required|string',

            'password_nuevo' => [
                'required',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->mixedCase()
                    ->numbers(),
            ],

            'password_nuevo_confirmation' => 'required|string',
        ], [
            'password_actual.required' => 'Debes ingresar tu contraseña actual.',
            'password_nuevo.required' => 'Debes ingresar una contraseña nueva.',
            'password_nuevo.confirmed' => 'La nueva contraseña y su confirmación no coinciden.',
            'password_nuevo_confirmation.required' => 'Debes confirmar la nueva contraseña.',
        ]);


        try {
            $respuesta = Http::withToken($token)
                ->acceptJson()
                ->timeout(15)
                ->put($this->apiUrl() . '/cliente/password', $datos);

            if ($respuesta->status() === 401) {
                $request->session()->forget([
                    'cliente_token',
                    'cliente'
                ]);

                return redirect()->route('cliente.login')
                    ->with('error', 'Tu sesión ha expirado.');
            }

            if ($respuesta->status() === 422) {
                return redirect()
                    ->route('cliente.perfil')
                    ->withErrors(
                        $respuesta->json('errors', []),
                        'password'
                    )
                    ->with('seccion', 'password');
            }

            if (!$respuesta->successful()) {
                return redirect()
                    ->route('cliente.perfil')
                    ->with('error', 'No se pudo cambiar la contraseña.');
            }

            return redirect()
                ->route('cliente.perfil')
                ->with('success', 'Contraseña actualizada correctamente.');

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return redirect()
                ->route('cliente.perfil')
                ->with('error', 'No se pudo conectar con la API.');
        }
    }



    // CERRAR SESIÓN DEL CLIENTE
    public function logout(Request $request)
    {
        $token = $request->session()->get('cliente_token');

        if ($token) {
            try {
                // Revocar el token en la API
                Http::withToken($token)
                    ->acceptJson()
                    ->timeout(15)
                    ->post($this->apiUrl() . '/cliente/logout');

            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                // Permitir el cierre local si la API no responde
            }
        }

        // Eliminar datos de autenticación y carrito
        $request->session()->forget([
            'cliente_token',
            'cliente',
            'carrito',
        ]);

        // Renovar el identificador de sesión
        $request->session()->migrate(true);
        $request->session()->regenerateToken();

        return redirect()->route('inicio')
            ->with('success', 'Sesión cerrada correctamente.');
    }

}
