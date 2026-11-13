@extends('layouts.app')

@section('contenido')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 mb-2">
                <i class="bi bi-broadcast"></i> Comunicación HTTP Activa
            </span>
            <h1 class="text-3xl font-bold text-slate-900">Panel de Control Administrativo</h1>
            <p class="text-slate-600 mt-1">
                Bienvenido, <span class="font-semibold text-amber-700">{{ $adminUser }}</span>. Todas las operaciones consumen la API externa mediante <code>Http::withToken()</code>.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-mono border border-emerald-200">
                <i class="bi bi-check-circle-fill"></i> Token Activo
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
    <!-- Administradores -->
    <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Módulo</span>
            <span class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i class="bi bi-people-fill"></i>
            </span>
        </div>
        <h3 class="text-lg font-bold text-slate-800">Administradores</h3>
        <p class="text-2xl font-extrabold text-indigo-600 mt-1">{{ $counts['administradores'] }}</p>
        <a href="{{ route('administradores.listar') }}" class="mt-4 block text-xs font-semibold text-indigo-600 hover:text-indigo-800">
            Gestionar &rarr;
        </a>
    </div>

    <!-- Productos -->
    <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Módulo</span>
            <span class="h-8 w-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="bi bi-box-seam-fill"></i>
            </span>
        </div>
        <h3 class="text-lg font-bold text-slate-800">Productos</h3>
        <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ $counts['productos'] }}</p>
        <a href="{{ route('productos.listar') }}" class="mt-4 block text-xs font-semibold text-amber-600 hover:text-amber-800">
            Gestionar &rarr;
        </a>
    </div>

    <!-- Proveedores -->
    <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Módulo</span>
            <span class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="bi bi-truck"></i>
            </span>
        </div>
        <h3 class="text-lg font-bold text-slate-800">Proveedores</h3>
        <p class="text-2xl font-extrabold text-blue-600 mt-1">{{ $counts['proveedores'] }}</p>
        <a href="{{ route('proveedores.listar') }}" class="mt-4 block text-xs font-semibold text-blue-600 hover:text-blue-800">
            Gestionar &rarr;
        </a>
    </div>

    <!-- Clientes -->
    <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Módulo</span>
            <span class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="bi bi-person-badge-fill"></i>
            </span>
        </div>
        <h3 class="text-lg font-bold text-slate-800">Clientes</h3>
        <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $counts['clientes'] }}</p>
        <a href="{{ route('clientes.listar') }}" class="mt-4 block text-xs font-semibold text-emerald-600 hover:text-emerald-800">
            Gestionar &rarr;
        </a>
    </div>

    <!-- Pedidos -->
    <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Módulo</span>
            <span class="h-8 w-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                <i class="bi bi-bag-check-fill"></i>
            </span>
        </div>
        <h3 class="text-lg font-bold text-slate-800">Pedidos</h3>
        <p class="text-2xl font-extrabold text-rose-600 mt-1">{{ $counts['pedidos'] }}</p>
        <a href="{{ route('pedidos.listar') }}" class="mt-4 block text-xs font-semibold text-rose-600 hover:text-rose-800">
            Gestionar &rarr;
        </a>
    </div>
</div>

<div class="p-5 bg-white border border-slate-200 rounded-xl shadow-sm">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
        <div class="flex items-center gap-2">
            <span class="h-8 w-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="bi bi-key-fill text-sm"></i>
            </span>
            <div>
                <h4 class="text-sm font-bold text-slate-800">Token de Autenticación (Sanctum)</h4>
                <p class="text-xs text-slate-500">Encabezado <code>Authorization: Bearer</code> utilizado en cada solicitud</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" id="btnToggleToken" onclick="toggleTokenVisibility()" 
                class="px-3 py-1.5 text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-lg transition flex items-center gap-1.5">
                <i class="bi bi-eye" id="iconEye"></i> <span id="textToggle">Mostrar</span>
            </button>
            <button type="button" onclick="copiarToken()" 
                class="px-3 py-1.5 text-xs font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-lg transition flex items-center gap-1.5">
                <i class="bi bi-clipboard"></i> <span id="textCopy">Copiar</span>
            </button>
        </div>
    </div>

    <div class="relative bg-slate-900 rounded-lg p-3 font-mono text-xs text-slate-100 overflow-x-auto">
        <span class="text-slate-400 select-none">Bearer </span>
        <span id="maskedToken" class="tracking-widest">••••••••••••••••••••••••••••••••••••••••••••••••</span>
        <span id="realToken" class="hidden select-all text-amber-400">{{ session('admin_token') }}</span>
    </div>
</div>

<script>
    function toggleTokenVisibility() {
        const masked = document.getElementById('maskedToken');
        const real = document.getElementById('realToken');
        const icon = document.getElementById('iconEye');
        const text = document.getElementById('textToggle');

        if (real.classList.contains('hidden')) {
            real.classList.remove('hidden');
            masked.classList.add('hidden');
            icon.className = 'bi bi-eye-slash';
            text.innerText = 'Ocultar';
        } else {
            real.classList.add('hidden');
            masked.classList.remove('hidden');
            icon.className = 'bi bi-eye';
            text.innerText = 'Mostrar';
        }
    }

    function copiarToken() {
        const token = "{{ session('admin_token') }}";
        navigator.clipboard.writeText(token).then(() => {
            const text = document.getElementById('textCopy');
            text.innerText = '¡Copiado!';
            setTimeout(() => { text.innerText = 'Copiar'; }, 2000);
        });
    }
</script>
@endsection
