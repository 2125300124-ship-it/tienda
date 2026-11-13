<div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-amber-600 font-bold text-xs uppercase tracking-widest mb-1">{{ $modelo }}</p>
        <h1 class="text-2xl font-bold text-slate-900">{{ $titulo }}</h1>
        <p class="text-sm text-slate-500">Datos obtenidos en tiempo real desde la API (GET /api/{{ $modulo }})</p>
    </div>
    @if (\Illuminate\Support\Facades\Route::has($modulo . '.formulario'))
        <a href="{{ route($modulo . '.formulario') }}" class="px-4 py-2.5 text-sm font-medium text-white bg-amber-500 rounded-lg hover:bg-amber-600 shadow-sm flex items-center gap-1.5 self-start sm:self-auto">
            <i class="bi bi-plus-lg"></i> Nuevo registro
        </a>
    @endif
</div>

<div class="overflow-x-auto border border-slate-200 rounded-xl shadow-sm">
    <table class="w-full text-sm text-left text-slate-600">
        <thead class="text-xs text-slate-700 uppercase bg-slate-100 border-b border-slate-200">
            <tr>
                <th scope="col" class="px-4 py-3.5">ID</th>
                @foreach ($campos as $campo)
                    @if (($campo['type'] ?? '') !== 'password')
                        <th scope="col" class="px-4 py-3.5">{{ $campo['label'] }}</th>
                    @endif
                @endforeach
                <th scope="col" class="px-4 py-3.5 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($registros as $registro)
                @php($id = is_array($registro) ? ($registro['id'] ?? null) : ($registro->id ?? null))
                <tr class="bg-white hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-mono text-xs text-slate-500 font-bold">#{{ $id }}</td>
                    @foreach ($campos as $campo)
                        @if (($campo['type'] ?? '') !== 'password')
                            @php($campoName = $campo['name'])
                            @php($valor = is_array($registro) ? ($registro[$campoName] ?? '—') : ($registro->$campoName ?? '—'))
                            <td class="px-4 py-3">
                                @if (($campo['type'] ?? '') === 'image')
                                    @if ($valor && $valor !== '—')
                                        <img src="{{ app(\App\Services\CloudinaryImageStorage::class)->url($valor) }}" 
                                             alt="{{ $campo['label'] }}" 
                                             loading="lazy" 
                                             class="h-12 w-12 rounded-lg border border-slate-200 object-cover shadow-sm">
                                    @else
                                        <span class="text-slate-400 text-xs italic">Sin imagen</span>
                                    @endif
                                @elseif (($campo['type'] ?? '') === 'select')
                                    @php($label = $campo['options'][$valor] ?? $valor)
                                    @if ($campoName === 'estado')
                                        <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full {{ ((string)$valor === '1' || $valor === 'Activo' || $valor === true) ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                            {{ ((string)$valor === '1' || $valor === 'Activo' || $valor === true) ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    @else
                                        {{ $label }}
                                    @endif
                                @elseif (($campo['type'] ?? '') === 'number')
                                    @if (in_array($campoName, ['precio', 'total', 'iva', 'descuento']))
                                        <span class="font-mono">${{ number_format((float)$valor, 2) }}</span>
                                    @else
                                        <span class="font-mono">{{ $valor }}</span>
                                    @endif
                                @else
                                    <span class="line-clamp-2">{{ $valor }}</span>
                                @endif
                            </td>
                        @endif
                    @endforeach
                    <td class="px-4 py-3 text-center">
                        <div class="inline-flex items-center gap-2">
                            @if (\Illuminate\Support\Facades\Route::has($modulo . '.mostrar'))
                                <a href="{{ route($modulo . '.mostrar', $id) }}" class="text-amber-600 hover:text-amber-800 font-medium text-xs flex items-center gap-0.5">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                            @endif

                            @if (\Illuminate\Support\Facades\Route::has($modulo . '.edicion'))
                                <a href="{{ route($modulo . '.edicion', $id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-xs flex items-center gap-0.5">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                            @endif

                            @if (\Illuminate\Support\Facades\Route::has($modulo . '.borrar'))
                                <form action="{{ route($modulo . '.borrar', $id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este registro vía API (DELETE)?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium text-xs flex items-center gap-0.5">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($campos) + 2 }}" class="px-6 py-12 text-center text-slate-400">
                        <i class="bi bi-inbox text-3xl mb-2 block"></i>
                        No hay registros disponibles en la API para {{ $titulo }}.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
