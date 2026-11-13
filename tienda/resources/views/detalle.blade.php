
@extends('layouts.app')

@section('titulo', 'Detalle - Collector Store')

@section('contenido')

<!-- REGRESAR -->
<a href="{{ route('catalogo') }}"
   class="text-decoration-none fw-semibold d-inline-block mb-4"
   style="color:#d99000;">
    ← Volver al catálogo
</a>

@if($error)

    <div class="alert alert-warning">
        {{ $error }}
    </div>

@elseif($producto)

    @php
        $imagenes = array_values(array_filter([
            $producto['imagen1'] ?? null,
            $producto['imagen2'] ?? null,
            $producto['imagen3'] ?? null,
        ]));
    @endphp

    <div class="seccion-tienda p-4 p-md-5">

        <span class="etiqueta">
            DETALLE DEL PRODUCTO
        </span>

        <h1 class="mt-2 mb-4">
            {{ $producto['nombre'] }}
        </h1>

        <div class="row g-4">

            <!-- GALERÍA DE IMÁGENES -->
            <div class="col-lg-6">

                @if(count($imagenes))

                    <!-- IMAGEN PRINCIPAL -->
                    <img
                        id="imagenPrincipal"
                        src="{{ $imagenes[0] }}"
                        alt="Imagen de {{ $producto['nombre'] }}"
                        class="w-100 rounded-3 mb-3"
                        style="
                            height:330px;
                            object-fit:contain;
                            background:#f8fafc;
                        "
                    >

                    <!-- TRES IMÁGENES -->
                    <div class="row g-2">

                        @foreach($imagenes as $imagen)

                            <div class="col-4">

                                <button
                                    type="button"
                                    class="w-100 p-1 bg-white rounded-3 border"
                                    onclick="document.getElementById('imagenPrincipal').src = this.querySelector('img').src"
                                    aria-label="Mostrar imagen {{ $loop->iteration }}"
                                >

                                    <img
                                        src="{{ $imagen }}"
                                        alt="Vista {{ $loop->iteration }}"
                                        loading="lazy"
                                        class="w-100"
                                        style="
                                            height:90px;
                                            object-fit:contain;
                                        "
                                    >

                                </button>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="
                            height:330px;
                            background:#f8fafc;
                            font-size:80px;
                         ">
                        📦
                    </div>

                    <p class="texto-secundario mt-2">
                        Este producto todavía no tiene imágenes.
                    </p>

                @endif

            </div>

            <!-- INFORMACIÓN DEL PRODUCTO -->
            <div class="col-lg-6">

                <span class="etiqueta">
                    COLLECTOR STORE
                </span>

                <h2 class="mt-2">
                    {{ $producto['nombre'] }}
                </h2>

                <p class="texto-secundario">
                    Código: #{{ $producto['id'] }}
                </p>

                <hr>

                <!-- PRECIO -->
                <h3 style="color:#d99000;">

                    ${{ number_format((float)($producto['precio'] ?? 0), 2) }}

                </h3>

                <!-- DESCRIPCIÓN -->
                <p class="texto-secundario mt-3">

                    {{ $producto['descripcion'] ?? 'Sin descripción disponible.' }}

                </p>

                <!-- EXISTENCIA -->
                <div class="p-3 rounded-3 mt-4"
                     style="
                        background:#f8fafc;
                        border:1px solid #e2e8f0;
                     ">

                    <strong>Existencia:</strong>
                    {{ $producto['existencia'] ?? 0 }} unidades

                    <hr>

                    <strong>Estado:</strong>

                    {{ ($producto['existencia'] ?? 0) > 0
                        ? 'Disponible'
                        : 'Agotado' }}

                </div>
                
                
                    <!-- AGREGAR AL CARRITO -->
                    <div class="mt-4">

                        @if(($producto['existencia'] ?? 0) > 0)

                            <form action="{{ route('carrito.agregar') }}"
                                method="POST">

                                @csrf

                                <input type="hidden"
                                    name="id"
                                    value="{{ $producto['id'] }}">

                                <div class="mb-3">

                                    <label for="cantidad"
                                        class="form-label fw-semibold">
                                        Cantidad
                                    </label>

                                    <input type="number"
                                        id="cantidad"
                                        name="cantidad"
                                        class="form-control"
                                        value="1"
                                        min="1"
                                        max="{{ $producto['existencia'] }}"
                                        required
                                        style="max-width:140px;">

                                </div>

                                <button type="submit"
                                        class="btn btn-tienda w-100">
                                    🛒 Agregar al carrito
                                </button>

                            </form>

                        @else

                            <button class="btn btn-secondary w-100" disabled>
                                Producto agotado
                            </button>

                        @endif

                    </div>



                <a href="{{ route('catalogo') }}"
                   class="btn btn-tienda mt-4">

                    Seguir explorando →

                </a>

            </div>

        </div>

    </div>

@else

    <div class="alert alert-warning">
        No se recibió información del producto.
    </div>

@endif

@endsection
