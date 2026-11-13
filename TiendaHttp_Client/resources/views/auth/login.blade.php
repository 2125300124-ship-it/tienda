<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo | HttpClient Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <main class="mx-auto flex min-h-screen max-w-md items-center px-4 py-8">
        <section class="w-full rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="mb-4">
                <a href="{{ url('/') }}" class="text-sm font-medium text-amber-700 hover:text-amber-800 flex items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Volver al inicio
                </a>
            </div>

            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-amber-500 text-white">
                    <i class="bi bi-shield-lock-fill text-lg"></i>
                </span>
                <h1 class="text-2xl font-bold text-slate-900">Área Administrativa</h1>
            </div>
            <p class="text-sm text-slate-600 mb-6">Autenticación por Token Sanctum consumiendo la API externa.</p>

            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('exito'))
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-800" role="alert">
                    {{ session('exito') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="usuario" class="mb-1 block text-sm font-medium text-slate-700">Usuario Administrador</label>
                    <input id="usuario" name="usuario" type="text" value="{{ old('usuario') }}" required autofocus
                        autocomplete="username" placeholder="Ej. ana o tu usuario admin"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="contraseña" class="mb-1 block text-sm font-medium text-slate-700">Contraseña</label>
                    <input id="contraseña" name="contraseña" type="password" required
                        autocomplete="current-password" placeholder="••••••••"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <button type="submit"
                    class="w-full rounded-lg bg-amber-500 px-4 py-2.5 font-semibold text-white shadow hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-300 flex items-center justify-center gap-2">
                    <i class="bi bi-key-fill"></i> Iniciar sesión con API
                </button>
            </form>


        </section>
    </main>
</body>
</html>
