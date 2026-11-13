<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product['title'] }} | FakeStore</title>
    <!-- Tailwind CSS CDN para garantizar carga inmediata -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <!-- Barra superior -->
    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur-sm shadow-xs">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white font-bold shadow-md shadow-indigo-200">
                    FS
                </div>
                <a href="{{ route('catalogo.index') }}" class="text-xl font-extrabold tracking-tight text-slate-900 hover:text-indigo-600 transition">
                    FakeStore
                </a>
            </div>

            <a
                href="{{ route('catalogo.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-xs hover:bg-slate-50 hover:text-indigo-600 transition"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Volver al catálogo</span>
            </a>
        </div>
    </header>

    <!-- Contenedor principal -->
    <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <!-- Migas de pan (Breadcrumbs) -->
        <nav class="mb-6 flex items-center gap-2 text-xs text-slate-500 font-medium">
            <a href="{{ route('catalogo.index') }}" class="hover:text-indigo-600 transition">Inicio</a>
            <span>/</span>
            <a href="{{ route('catalogo.index') }}" class="hover:text-indigo-600 transition">Catálogo</a>
            <span>/</span>
            <span class="capitalize text-slate-700 font-semibold">{{ $product['category'] ?? 'General' }}</span>
            <span>/</span>
            <span class="truncate max-w-[200px] text-slate-400">#{{ $product['id'] }}</span>
        </nav>

        <!-- Tarjeta de Detalle del Producto -->
        <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50">
            <div class="grid gap-8 p-6 md:grid-cols-2 md:p-12 lg:gap-16">
                <!-- Columna Izquierda: Imagen del producto -->
                <div class="flex flex-col items-center justify-center rounded-2xl bg-slate-50/80 p-8 border border-slate-100">
                    <div class="relative flex h-80 w-full items-center justify-center sm:h-96">
                        <img
                            src="{{ $product['image'] }}"
                            alt="{{ $product['title'] }}"
                            class="max-h-full max-w-full object-contain drop-shadow-md transition duration-300 hover:scale-105"
                        >
                    </div>
                    <span class="mt-4 text-[11px] font-medium text-slate-400">
                        Imagen provista por FakeStore API
                    </span>
                </div>

                <!-- Columna Derecha: Información y especificaciones -->
                <div class="flex flex-col justify-between">
                    <div>
                        <!-- Badges superiores -->
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-lg bg-indigo-50 px-2.5 py-1 text-xs font-bold uppercase tracking-wider text-indigo-700 ring-1 ring-inset ring-indigo-600/20">
                                {{ $product['category'] ?? 'Sin categoría' }}
                            </span>
                            <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                Código #{{ $product['id'] }}
                            </span>
                            <span class="inline-flex items-center gap-1 rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                En inventario
                            </span>
                        </div>

                        <!-- Título -->
                        <h1 class="mt-4 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">
                            {{ $product['title'] }}
                        </h1>

                        <!-- Rating y Reseñas -->
                        @if (isset($product['rating']))
                            <div class="mt-3 flex items-center gap-2">
                                <div class="flex items-center text-amber-500 text-sm">
                                    ★ ★ ★ ★ ★
                                </div>
                                <span class="text-sm font-bold text-slate-800">
                                    {{ number_format((float) ($product['rating']['rate'] ?? 0), 1) }}
                                </span>
                                <span class="text-xs text-slate-500">
                                    ({{ $product['rating']['count'] ?? 0 }} valoraciones de clientes)
                                </span>
                            </div>
                        @endif

                        <!-- Precio -->
                        <div class="mt-6 rounded-2xl bg-slate-50 p-4 border border-slate-100">
                            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Precio especial</span>
                            <div class="mt-1 flex items-baseline gap-3">
                                <p class="text-4xl font-black text-slate-900">
                                    ${{ number_format((float) $product['price'], 2) }}
                                </p>
                                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">
                                    Envío gratis
                                </span>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mt-6">
                            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Descripción del producto
                            </h2>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                                {{ $product['description'] }}
                            </p>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row border-t border-slate-100 pt-6">
                        <a
                            href="{{ route('catalogo.index') }}"
                            class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3.5 text-center text-sm font-bold text-white shadow-md shadow-indigo-300/50 transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Regresar al catálogo</span>
                        </a>

                        <a
                            href="{{ url('/api/fakestore/productos/detalle/' . $product['id']) }}"
                            target="_blank"
                            class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-slate-300 bg-white px-5 py-3.5 text-xs font-semibold text-slate-700 shadow-xs hover:bg-slate-50 hover:text-indigo-600 transition"
                        >
                            <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                            Ver en JSON
                        </a>
                    </div>
                </div>
            </div>
        </article>

        <section class="mt-10 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="comments-title">
            <div class="mb-6">
                <h2 id="comments-title" class="text-xl font-black text-slate-900">Comentarios</h2>
                <p class="mt-1 text-sm text-slate-500">Comparte tu opinión sobre este producto.</p>
            </div>

            @if (session('success'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
                    <p class="font-semibold">Revisa los datos del comentario:</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('catalogo.comentarios.store', $product['id']) }}" method="POST" class="mb-8 grid gap-4 sm:grid-cols-2">
                @csrf
                <div>
                    <label for="comment-author" class="mb-1 block text-sm font-semibold text-slate-700">Tu nombre</label>
                    <input
                        id="comment-author"
                        name="autor"
                        value="{{ old('autor') }}"
                        required
                        maxlength="100"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                    >
                </div>
                <div class="sm:col-span-2">
                    <label for="new-comment" class="mb-1 block text-sm font-semibold text-slate-700">Comentario</label>
                    <textarea
                        id="new-comment"
                        name="contenido"
                        rows="3"
                        required
                        maxlength="2000"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                    >{{ old('contenido') }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                        Agregar comentario
                    </button>
                </div>
            </form>

            <div class="space-y-4">
                @forelse ($comments as $comment)
                    <article class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h3 class="font-bold text-slate-900">{{ $comment->autor }}</h3>
                                <time class="text-xs text-slate-500" datetime="{{ $comment->created_at->toIso8601String() }}">
                                    {{ $comment->created_at->format('d/m/Y H:i') }}
                                    @if ($comment->updated_at->gt($comment->created_at))
                                        &middot; editado
                                    @endif
                                </time>
                            </div>
                            <div class="flex items-center gap-3">
                                <details>
                                    <summary class="cursor-pointer text-sm font-semibold text-indigo-600 hover:text-indigo-800">Editar</summary>
                                    <form action="{{ route('catalogo.comentarios.update', [$product['id'], $comment->id]) }}" method="POST" class="mt-3 w-full sm:w-96">
                                        @csrf
                                        @method('PUT')
                                        <label for="comment-{{ $comment->id }}" class="sr-only">Editar comentario de {{ $comment->autor }}</label>
                                        <textarea
                                            id="comment-{{ $comment->id }}"
                                            name="contenido"
                                            rows="3"
                                            required
                                            maxlength="2000"
                                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                                        >{{ $comment->contenido }}</textarea>
                                        <button type="submit" class="mt-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                                            Guardar cambios
                                        </button>
                                    </form>
                                </details>
                                <form
                                    action="{{ route('catalogo.comentarios.destroy', [$product['id'], $comment->id]) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar este comentario?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800">Eliminar</button>
                                </form>
                            </div>
                        </div>
                        <p class="mt-3 whitespace-pre-wrap text-sm leading-relaxed text-slate-700">{{ $comment->contenido }}</p>
                    </article>
                @empty
                    <p class="rounded-xl bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                        Aún no hay comentarios. ¡Sé el primero en opinar!
                    </p>
                @endforelse
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="mt-16 border-t border-slate-200 bg-white py-6 text-center text-xs text-slate-500">
        <p>Proyecto Laravel 12 &bull; Consumo de API FakeStore &bull; Actividad Individual</p>
    </footer>
</body>
</html>