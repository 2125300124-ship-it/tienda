<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos | FakeStore API</title>
    <!-- Tailwind CSS CDN para garantizar carga inmediata -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <!-- Barra de navegación -->
    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur-sm shadow-xs">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white font-bold shadow-md shadow-indigo-200">
                    FS
                </div>
                <div>
                    <a href="{{ route('catalogo.index') }}" class="text-xl font-extrabold tracking-tight text-slate-900 hover:text-indigo-600 transition">
                        FakeStore
                    </a>
                    <span class="block text-xs font-medium text-slate-400">Consumo de API Externa</span>
                </div>
            </div>

            <nav class="flex items-center gap-3">
                <a href="{{ url('/api/fakestore/productos') }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
                    <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                    Ver JSON API
                </a>
                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                    ● En línea
                </span>
            </nav>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <!-- Encabezado de la página -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 pb-8 border-b border-slate-200">
            <div>
                <span class="inline-block rounded-md bg-indigo-100 px-2.5 py-1 text-xs font-semibold tracking-wide text-indigo-700 uppercase">
                    Catálogo Interactivo
                </span>
                <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                    Nuestros Productos
                </h1>
                <p class="mt-2 text-sm text-slate-600 max-w-2xl">
                    Datos obtenidos en tiempo real desde la API pública de <a href="https://fakestoreapi.com" target="_blank" class="text-indigo-600 underline font-medium">FakeStore</a>. Haz clic en la imagen o en el botón para ver el detalle de cada producto.
                </p>
            </div>

            <!-- Buscador y filtro en vivo -->
            <div class="w-full md:w-80">
                <label for="search-input" class="sr-only">Buscar productos</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="search-input"
                        placeholder="Buscar por nombre o categoría..."
                        class="block w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
                        oninput="filtrarProductos()"
                    >
                </div>
            </div>
        </div>

        <!-- Contador de resultados -->
        <div class="py-4 flex items-center justify-between text-xs text-slate-500 font-medium">
            <span id="product-counter">Mostrando {{ count($products) }} productos disponibles</span>
        </div>

        <!-- Grid de productos -->
        @if (count($products))
            <div id="products-grid" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <article
                        class="product-card group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xs transition duration-200 hover:-translate-y-1 hover:shadow-xl hover:border-indigo-200"
                        data-title="{{ strtolower($product['title']) }}"
                        data-category="{{ strtolower($product['category'] ?? '') }}"
                    >
                        <!-- Imagen con enlace -->
                        <a
                            href="{{ route('catalogo.producto', $product['id']) }}"
                            class="relative flex h-60 items-center justify-center overflow-hidden bg-slate-50 p-6 transition group-hover:bg-slate-100/60"
                        >
                            <img
                                src="{{ $product['image'] }}"
                                alt="{{ $product['title'] }}"
                                class="max-h-full max-w-full object-contain transition duration-300 group-hover:scale-105"
                                loading="lazy"
                            >
                            <span class="absolute top-3 left-3 rounded-md bg-white/90 backdrop-blur-xs px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-700 shadow-xs">
                                {{ $product['category'] }}
                            </span>
                        </a>

                        <!-- Datos del producto -->
                        <div class="flex flex-1 flex-col p-5">
                            <h2 class="line-clamp-2 min-h-12 text-sm font-semibold text-slate-900 group-hover:text-indigo-600 transition">
                                <a href="{{ route('catalogo.producto', $product['id']) }}">
                                    {{ $product['title'] }}
                                </a>
                            </h2>

                            <!-- Precio y Rating -->
                            <div class="mt-4 flex items-baseline justify-between gap-2 border-t border-slate-100 pt-3">
                                <div>
                                    <span class="text-xs text-slate-400">Precio</span>
                                    <p class="text-xl font-black text-slate-900">
                                        ${{ number_format((float) $product['price'], 2) }}
                                    </p>
                                </div>

                                @if (isset($product['rating']['rate']))
                                    <div class="flex items-center gap-1 rounded-md bg-amber-50 px-2 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                        <span>★</span>
                                        <span>{{ number_format((float) $product['rating']['rate'], 1) }}</span>
                                        <span class="text-[10px] text-amber-500">({{ $product['rating']['count'] ?? 0 }})</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Botón de acción con enlace al detalle -->
                            <a
                                href="{{ route('catalogo.producto', $product['id']) }}"
                                class="mt-4 inline-flex w-full items-center justify-center gap-1.5 rounded-xl bg-indigo-600 px-4 py-2.5 text-center text-xs font-bold text-white shadow-sm shadow-indigo-300/50 transition hover:bg-indigo-700 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-indigo-100"
                            >
                                <span>Ver detalle</span>
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Mensaje cuando no hay resultados de búsqueda -->
            <div id="no-results" class="hidden text-center py-16">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-3 text-base font-semibold text-slate-900">Sin coincidencias</h3>
                <p class="mt-1 text-sm text-slate-500">No encontramos productos con ese término de búsqueda.</p>
            </div>
        @else
            <div class="rounded-2xl border border-slate-200 bg-white p-12 text-center shadow-xs">
                <svg class="mx-auto h-12 w-12 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <h3 class="mt-4 text-lg font-bold text-slate-900">No hay productos disponibles</h3>
                <p class="mt-2 text-sm text-slate-500">No se pudieron cargar los datos desde la API externa de FakeStore. Revisa tu conexión a internet.</p>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="mt-16 border-t border-slate-200 bg-white py-6 text-center text-xs text-slate-500">
        <p>Proyecto Laravel 12 &bull; Consumo de API FakeStore &bull; Actividad Individual</p>
    </footer>

    <!-- Script de filtrado interactivo -->
    <script>
        function filtrarProductos() {
            const query = document.getElementById('search-input').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const title = card.getAttribute('data-title');
                const category = card.getAttribute('data-category');

                if (title.includes(query) || category.includes(query)) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const counter = document.getElementById('product-counter');
            const noResults = document.getElementById('no-results');

            if (counter) {
                counter.textContent = `Mostrando ${visibleCount} de {{ count($products) }} productos`;
            }

            if (noResults) {
                if (visibleCount === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>