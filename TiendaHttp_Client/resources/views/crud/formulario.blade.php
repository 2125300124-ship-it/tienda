<div class="max-w-3xl">
    <div class="mb-6">
        <p class="text-amber-600 font-bold text-xs uppercase tracking-widest mb-1">{{ $modelo }}</p>
        <h1 class="text-2xl font-bold text-slate-900">
            {{ $modo === 'crear' ? 'Registrar nuevo' : 'Editar' }}: {{ $titulo }}
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Los datos serán enviados a la API externa mediante el método HTTP 
            <strong>{{ $modo === 'crear' ? 'POST' : 'PUT' }}</strong>.
        </p>
    </div>

    @if ($modo === 'crear')
        <form action="{{ route($modulo . '.registrar') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @else
        <form action="{{ route($modulo . '.actualizar', $id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @method('PUT')
    @endif
        @csrf

        @foreach ($campos as $campo)
            @php($nombre = $campo['name'])
            @php($tipo = $campo['type'] ?? 'text')
            @php($columna = $campo['column'] ?? $nombre)
            @php($valorActual = is_array($registro) ? ($registro[$columna] ?? ($registro[$nombre] ?? '')) : ($registro->$columna ?? ($registro->$nombre ?? '')))
            @php($valor = old($nombre, $valorActual))

            <div>
                <label for="{{ $nombre }}" class="block mb-2 text-sm font-medium text-slate-900">
                    {{ $campo['label'] }}{{ ($campo['required'] ?? false) ? ' *' : '' }}
                </label>

                @if ($tipo === 'select')
                    <select id="{{ $nombre }}" name="{{ $nombre }}" @required($campo['required'] ?? false) 
                        class="block w-full p-2.5 text-sm border rounded-lg bg-white @error($nombre) border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-amber-200 focus:outline-none">
                        <option value="">-- Selecciona una opción --</option>
                        @foreach ($campo['options'] as $opcion => $etiqueta)
                            <option value="{{ $opcion }}" @selected((string)$valor === (string)$opcion)>
                                {{ $etiqueta }}
                            </option>
                        @endforeach
                    </select>

                @elseif ($tipo === 'textarea')
                    <textarea id="{{ $nombre }}" name="{{ $nombre }}" rows="3" @required($campo['required'] ?? false) 
                        class="block w-full p-2.5 text-sm border rounded-lg @error($nombre) border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-amber-200 focus:outline-none">{{ $valor }}</textarea>

                @elseif ($tipo === 'image')
                    <input id="{{ $nombre }}" name="{{ $nombre }}" type="file" accept="image/png,image/jpeg,image/webp" 
                        data-image-preview="image-preview-{{ $nombre }}" 
                        @required(($campo['required'] ?? false) && $modo === 'crear') 
                        class="block w-full p-2 text-sm border rounded-lg bg-slate-50 @error($nombre) border-red-500 @else border-slate-300 @enderror">
                    
                    @php($imgUrl = app(\App\Services\CloudinaryImageStorage::class)->url($valorActual))
                    <img id="image-preview-{{ $nombre }}" 
                         src="{{ $imgUrl ?? '' }}" 
                         alt="Vista previa de {{ strtolower($campo['label']) }}" 
                         @class(['hidden' => !$imgUrl, 'mt-3 h-28 w-28 rounded-lg border border-slate-200 object-cover shadow-sm'])>

                @else
                    <input id="{{ $nombre }}" name="{{ $nombre }}" 
                        type="{{ $tipo === 'password' ? 'password' : ($tipo === 'number' ? 'text' : $tipo) }}" 
                        value="{{ $tipo === 'password' ? '' : $valor }}" 
                        @required(($campo['required'] ?? false) && !($modo === 'editar' && $tipo === 'password')) 
                        @if ($tipo === 'number') inputmode="decimal" data-numeric-only @endif 
                        @if ($tipo === 'password') minlength="6" placeholder="{{ $modo === 'editar' ? 'Dejar en blanco para no modificar' : 'Mínimo 6 caracteres' }}" @endif 
                        class="block w-full p-2.5 text-sm border rounded-lg @error($nombre) border-red-500 @else border-slate-300 @enderror focus:ring-2 focus:ring-amber-200 focus:outline-none">
                @endif

                @error($nombre)
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
            <a href="{{ route($modulo . '.listar') }}" class="px-4 py-2 text-sm border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-amber-500 rounded-lg hover:bg-amber-600 shadow transition flex items-center gap-1.5">
                <i class="bi bi-send-fill"></i> {{ $modo === 'crear' ? 'Guardar vía API (POST)' : 'Actualizar vía API (PUT)' }}
            </button>
        </div>
    </form>
</div>
