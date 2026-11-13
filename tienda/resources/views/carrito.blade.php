
@extends('layouts.app')

@section('titulo', 'Carrito de compras - Collector Store')

@section('contenido')

<!-- ENCABEZADO -->
<div class="seccion-tienda p-4 p-md-5 mb-4">
    <span class="etiqueta">TUS PRODUCTOS</span>

    <h1 class="mt-2">🛒 Carrito de compras</h1>

    <p class="texto-secundario mb-0">
        Consulta y administra los productos que agregaste.
    </p>
</div>

@if(empty($carrito))

    <!-- CARRITO VACÍO -->
    <div class="seccion-tienda p-5 text-center">
        <div style="font-size:65px;">🛒</div>

        <h3 class="mt-3">Tu carrito está vacío</h3>

        <p class="texto-secundario">
            Todavía no has agregado ningún producto.
        </p>

        <a href="{{ route('catalogo') }}"
           class="btn btn-tienda mt-3">
            Explorar productos →
        </a>
    </div>

@else

<div class="row g-4">

    <!-- LISTA DE PRODUCTOS -->
    <div class="col-lg-8">

        @foreach($carrito as $producto)

        <div class="card mb-3">
            <div class="card-body">

                <div class="row align-items-center g-3">

                    <!-- IMAGEN -->
                    <div class="col-md-3 text-center">

                        @if(!empty($producto['imagen']))
                            <img
                                src="{{ $producto['imagen'] }}"
                                alt="{{ $producto['nombre'] }}"
                                class="img-fluid rounded-3"
                                style="height:130px; width:100%; object-fit:contain;"
                            >
                        @else
                            <div class="rounded-3 p-4"
                                 style="background:#f8fafc; font-size:45px;">
                                📦
                            </div>
                        @endif

                    </div>

                    <!-- INFORMACIÓN -->
                    <div class="col-md-9">

                        <h5>{{ $producto['nombre'] }}</h5>

                        <p class="texto-secundario mb-2">
                            Precio unitario:
                            ${{ number_format($producto['precio'], 2) }}
                        </p>

                        <!-- ACTUALIZAR CANTIDAD -->
                        <form
                            action="{{ route('carrito.actualizar', $producto['id']) }}"
                            method="POST"
                            class="d-flex align-items-end gap-2 flex-wrap mb-3">

                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="form-label fw-semibold">
                                    Cantidad
                                </label>

                                <input
                                    type="number"
                                    name="cantidad"
                                    class="form-control"
                                    value="{{ $producto['cantidad'] }}"
                                    min="1"
                                    max="{{ $producto['existencia'] }}"
                                    required
                                    style="width:100px;"
                                >
                            </div>

                            <button type="submit" class="btn btn-tienda">
                                Actualizar
                            </button>
                        </form>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                            <!-- SUBTOTAL -->
                            <div>
                                <small class="texto-secundario">Subtotal:</small>

                                <h5 class="mb-0" style="color:#d99000;">
                                    ${{ number_format(
                                        $producto['precio'] * $producto['cantidad'], 2
                                    ) }}
                                </h5>
                            </div>

                            <!-- ELIMINAR -->
                            <form
                                action="{{ route('carrito.eliminar', $producto['id']) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-outline-danger">
                                    Eliminar
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

            </div>
        </div>

        @endforeach

    </div>

    <!-- RESUMEN DEL CARRITO -->
    <div class="col-lg-4">

        <div class="card">
            <div class="card-body">

                <span class="etiqueta">RESUMEN</span>

                <h4 class="mt-2 mb-4">
                    Resumen del carrito
                </h4>

                <div class="d-flex justify-content-between mb-3">
                    <span class="texto-secundario">Unidades:</span>

                    <strong>
                        {{ collect($carrito)->sum('cantidad') }}
                    </strong>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">

                    <h5 class="mb-0">Total:</h5>

                    <h3 class="mb-0" style="color:#d99000;">
                        ${{ number_format($total, 2) }}
                    </h3>

                </div>

                <a href="{{ route('catalogo') }}"
                   class="btn btn-tienda w-100 mb-3">
                    Seguir comprando →
                </a>

                <!-- VACIAR CARRITO -->
                <form action="{{ route('carrito.vaciar') }}"
                      method="POST">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-outline-danger w-100"
                            onclick="return confirm('¿Deseas vaciar todo el carrito?')">
                        Vaciar carrito
                    </button>

                </form>

            </div>
        </div>

    </div>

</div>

@endif

@endsection
