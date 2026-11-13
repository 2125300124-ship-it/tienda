<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collector Store | HttpClient Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">
    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-lg text-slate-900">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500 text-white">
                    <i class="bi bi-star-fill text-sm"></i>
                </span>
                Collector Store <span class="text-xs bg-amber-100 text-amber-800 font-semibold px-2 py-0.5 rounded-full">HttpClient</span>
            </a>

            <div class="hidden md:flex flex-wrap items-center justify-end gap-x-4 gap-y-2 text-sm font-medium">
                @if (session('admin_token'))
                    <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-amber-600">Panel</a>
                    <a href="{{ route('administradores.listar') }}" class="text-slate-600 hover:text-amber-600">Administradores</a>
                    <a href="{{ route('productos.listar') }}" class="text-slate-600 hover:text-amber-600">Productos</a>
                    <a href="{{ route('proveedores.listar') }}" class="text-slate-600 hover:text-amber-600">Proveedores</a>
                    <a href="{{ route('clientes.listar') }}" class="text-slate-600 hover:text-amber-600">Clientes</a>
                    <a href="{{ route('pedidos.listar') }}" class="text-slate-600 hover:text-amber-600">Pedidos</a>
                    
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200" title="Token Sanctum activo">
                        <i class="bi bi-shield-check"></i> {{ session('admin_user.usuario', 'Admin') }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-700 hover:underline flex items-center gap-1">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-amber-600 font-semibold hover:text-amber-700 flex items-center gap-1">
                        <i class="bi bi-person-lock"></i> Acceso administrativo
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        @if (session('exito'))
            <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 flex items-center gap-2" role="status">
                <i class="bi bi-check-circle-fill text-green-600 text-lg"></i>
                <span>{{ session('exito') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-6 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200" role="alert">
                <div class="flex items-center gap-2 font-semibold mb-1">
                    <i class="bi bi-exclamation-triangle-fill text-red-600 text-lg"></i>
                    <span>Atención</span>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
            @yield('contenido')
        </div>
    </main>

    <script>
        document.addEventListener('input', (event) => {
            const input = event.target;
            if (!(input instanceof HTMLInputElement)) return;

            if (input.hasAttribute('data-letters-only')) {
                input.value = input.value.replace(/[^\p{L}\p{M}\s'-]/gu, '');
            }

            if (input.hasAttribute('data-numeric-only')) {
                const integerOnly = input.dataset.integer === 'true';
                let value = input.value.replace(integerOnly ? /\D/g : /[^\d.]/g, '');

                if (!integerOnly) {
                    const [whole, ...fraction] = value.split('.');
                    value = whole + (fraction.length ? `.${fraction.join('')}` : '');
                }

                input.value = value;
            }
        });

        document.addEventListener('change', (event) => {
            const input = event.target;
            if (!(input instanceof HTMLInputElement) || !input.dataset.imagePreview) return;

            const preview = document.getElementById(input.dataset.imagePreview);
            if (!preview) return;

            if (preview.dataset.objectUrl) URL.revokeObjectURL(preview.dataset.objectUrl);
            const file = input.files?.[0];
            if (!file) return;

            preview.dataset.objectUrl = URL.createObjectURL(file);
            preview.src = preview.dataset.objectUrl;
            preview.classList.remove('hidden');
        });
    </script>
</body>
</html>
