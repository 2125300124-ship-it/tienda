<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = rtrim(env('API_URL', 'http://127.0.0.1:8000/api'), '/');
    }

    public function index(): View
    {
        $token = session('admin_token');
        $counts = [
            'administradores' => 0,
            'productos' => 0,
            'proveedores' => 0,
            'clientes' => 0,
            'pedidos' => 0,
        ];

        // Fetch counts from API
        if ($token) {
            foreach (array_keys($counts) as $resource) {
                try {
                    $res = Http::withToken($token)
                        ->acceptJson()
                        ->timeout(3)
                        ->get("{$this->apiUrl}/{$resource}?per_page=1");
                    if ($res->successful()) {
                        $counts[$resource] = $res->json('total') ?? count($res->json('data') ?? []);
                    }
                } catch (\Exception $e) {
                    // Ignore background counter errors
                }
            }
        }

        return view('dashboard', [
            'counts' => $counts,
            'adminUser' => session('admin_user.usuario', 'Administrador'),
        ]);
    }
}
