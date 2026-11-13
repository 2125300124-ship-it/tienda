<div class="max-w-3xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="text-amber-600 font-bold text-xs uppercase tracking-widest mb-1">{{ $modelo }}</p>
            <h1 class="text-2xl font-bold text-slate-900">Detalle de {{ $titulo }} #{{ $id }}</h1>
            <p class="text-xs text-slate-500">Obtenido mediante GET /api/{{ $modulo }}/{{ $id }}</p>
        </div>
        <span class="px-2.5 py-1 text-xs font-mono font-bold rounded-lg bg-slate-100 text-slate-700 border border-slate-200">
            ID: {{ $id }}
        </span>
    </div>

    <dl class="divide-y divide-slate-200 border-y border-slate-200 bg-white">
        @foreach ($campos as $campo)
            @if (($campo['type'] ?? '') !== 'password')
                @php($campoName = $campo['name'])
                @php($valor = is_array($registro) ? ($registro[$campoName] ?? '—') : ($registro->$campoName ?? '—'))
                <div class="grid grid-cols-1 gap-1 py-3.5 sm:grid-cols-3 sm:gap-4 px-2 hover:bg-slate-50 transition">
                    <dt class="text-sm font-semibold text-slate-600">{{ $campo['label'] }}</dt>
                    <dd class="text-sm text-slate-900 sm:col-span-2">
                        @if (($campo['type'] ?? '') === 'image')
                            @if ($valor && $valor !== '—')
                                <img src="{{ app(\App\Services\CloudinaryImageStorage::class)->url($valor) }}" 
                                     alt="{{ $campo['label'] }}" 
                                     class="h-36 w-36 rounded-xl border border-slate-200 object-cover shadow-sm">
                            @else
                                <span class="text-slate-400 text-xs italic">Sin imagen asignada</span>
                            @endif
                        @elseif (($campo['type'] ?? '') === 'select')
                            @php($label = $campo['options'][$valor] ?? $valor)
                            @if ($campoName === 'estado')
                                <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full {{ ((string)$valor === '1' || $valor === 'Activo' || $valor === true) ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ ((string)$valor === '1' || $valor === 'Activo' || $valor === true) ? 'Activo' : 'Inactivo' }}
                                </span>
                            @else
                                <span class="font-medium">{{ $label }}</span>
                            @endif
                        @elseif (($campo['type'] ?? '') === 'number')
                            @if (in_array($campoName, ['precio', 'total', 'iva', 'descuento']))
                                <span class="font-mono font-bold text-slate-800">${{ number_format((float)$valor, 2) }}</span>
                            @else
                                <span class="font-mono">{{ $valor }}</span>
                            @endif
                        @else
                            <span>{{ $valor }}</span>
                        @endif
                    </dd>
                </div>
            @endif
        @endforeach
    </dl>

    <div class="flex gap-3 mt-6 pt-2">
        <a href="{{ route($modulo . '.listar') }}" class="px-4 py-2 text-sm border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition flex items-center gap-1.5">
            <i class="bi bi-arrow-left"></i> Volver al listado
        </a>
        @if (\Illuminate\Support\Facades\Route::has($modulo . '.edicion'))
            <a href="{{ route($modulo . '.edicion', $id) }}" class="px-4 py-2 text-sm text-white bg-amber-500 rounded-lg hover:bg-amber-600 transition flex items-center gap-1.5">
                <i class="bi bi-pencil-square"></i> Editar registro
            </a>
        @endif
    </div>
</div>
