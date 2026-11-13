<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = rtrim(env('API_URL', 'http://127.0.0.1:8000/api'), '/');
    }

    public function showLogin(): View|RedirectResponse
    {
        if (session()->has('admin_token') && !empty(session('admin_token'))) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'usuario' => 'required|string',
            'contraseña' => 'required|string',
        ]);

        $usuarioInput = $request->input('usuario');
        $passInput = $request->input('contraseña');

        // Compatible tanto con APIs que esperan (usuario, contraseña) como (email, password)
        $payload = [
            'usuario' => $usuarioInput,
            'email' => $usuarioInput,
            'contraseña' => $passInput,
            'password' => $passInput,
        ];

        try {
            $response = Http::acceptJson()
                ->timeout(10)
                ->post($this->apiUrl . '/login', $payload);
        } catch (\Exception $e) {
            Log::error('Error de conexión con la API en login: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'No fue posible conectar con el servidor API en ' . $this->apiUrl . '. Verifica que el servidor de la API esté encendido.'])
                ->withInput();
        }

        if (!$response->successful()) {
            $mensaje = $response->json('message') ?? 'Usuario o contraseña incorrectos.';
            return back()->withErrors(['error' => $mensaje])->withInput();
        }

        $token = $response->json('access_token') ?? $response->json('token');
        if (!$token) {
            return back()->withErrors(['error' => 'La API no devolvió un token de acceso válido.'])->withInput();
        }

        session([
            'admin_token' => $token,
            'admin_user' => [
                'usuario' => $usuarioInput,
            ],
        ]);

        return redirect()->route('dashboard')
            ->with('exito', 'Autenticación exitosa. Token Bearer recibido de la API.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $token = session('admin_token');

        if ($token) {
            try {
                Http::withToken($token)
                    ->acceptJson()
                    ->timeout(5)
                    ->post($this->apiUrl . '/logout');
            } catch (\Exception $e) {
                Log::warning('No se pudo revocar el token en la API: ' . $e->getMessage());
            }
        }

        $request->session()->forget(['admin_token', 'admin_user']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('exito', 'Sesión cerrada correctamente. Token revocado.');
    }
}
