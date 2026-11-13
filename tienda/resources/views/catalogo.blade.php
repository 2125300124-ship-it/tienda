
@extends('layouts.app')

@section('titulo', 'Catálogo - Collector Store')

@section('contenido')

<!-- ENCABEZADO -->
<div class="seccion-tienda p-4 p-md-5 mb-4">

    <span class="etiqueta">PRODUCTOS</span>

    <h1 class="mt-2">Nuestro catálogo</h1>

    <p class="texto-secundario mb-0">
        Explora los coleccionables disponibles en Collector Store.
    </p>

</div>

<!-- VALIDAR SI EXISTEN PRODUCTOS -->
@if($error)

    <div class="alert alert-warning">
        {{ $error }}
    </div>

@elseif(empty($productos))

    <div class="seccion-tienda p-4 text-center">

        <h4>Sin productos disponibles</h4>

        <p class="texto-secundario mb-0">
            Todavía no hay coleccionables activos en la API.
        </p>

    </div>

@else

    <!-- LISTADO DE PRODUCTOS -->
    <div class="row g-4">

        @foreach($productos as $producto)

            <div class="col-md-6 col-lg-4">

                <div class="card h-100 overflow-hidden">

                    <!-- IMAGEN -->
                    @if(!empty($producto['imagen1']))

                        <img
                            src="{{ $producto['imagen1'] }}"
                            alt="{{ $producto['nombre'] }}"
                            loading="lazy"
                            class="card-img-top"
                            style="
                                height:220px;
                                object-fit:contain;
                                background:#f8fafc;
                                padding:15px;
                            "
                        >

                    @else

                        <div class="d-flex justify-content-center align-items-center"
                             style="
                                height:220px;
                                background:#f8fafc;
                                font-size:60px;
                             ">
                            📦
                        </div>

                    @endif

                    <!-- INFORMACIÓN -->
                    <div class="card-body d-flex flex-column">

                        <span class="etiqueta">
                            COLECCIONABLE
                        </span>

                        <h5 class="mt-2">
                            {{ $producto['nombre'] }}
                        </h5>

                        <p class="texto-secundario">
                            {{ \Illuminate\Support\Str::limit($producto['descripcion'] ?? 'Sin descripción', 110) }}
                        </p>

                        <!-- EXISTENCIA -->
                        <p class="mb-3">

                            <span class="badge {{ ($producto['existencia'] ?? 0) > 0 ? 'bg-success' : 'bg-secondary' }}">

                                {{ ($producto['existencia'] ?? 0) > 0
                                    ? 'Disponible: '.$producto['existencia']
                                    : 'Agotado' }}

                            </span>

                        </p>

                        <!-- PRECIO Y BOTÓN -->
                        <div class="d-flex justify-content-between align-items-center gap-2 mt-auto">

                            <strong class="fs-4" style="color:#d99000;">

                                ${{ number_format((float)($producto['precio'] ?? 0), 2) }}

                            </strong>

                            <a href="{{ route('detalle', $producto['id']) }}"
                               class="btn btn-tienda">

                                Ver detalle →

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@endif

@endsection
