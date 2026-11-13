<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminTokenAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('admin_token') || empty($request->session()->get('admin_token'))) {
            return redirect()->route('login')
                ->withErrors(['error' => 'Debes iniciar sesión como administrador para acceder al área administrativa.']);
        }

        return $next($request);
    }
}
