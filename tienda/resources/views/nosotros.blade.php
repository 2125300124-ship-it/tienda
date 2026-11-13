
@extends('layouts.app')

@section('titulo', 'Nosotros - Collector Store')

@section('contenido')

<!-- ENCABEZADO -->
<div class="seccion-tienda p-4 p-md-5 mb-4">

    <span class="etiqueta">SOBRE NOSOTROS</span>

    <h1 class="mt-3 mb-3">
        Conoce Collector Store
    </h1>

    <p class="lead texto-secundario mb-0">
        Somos una tienda dedicada a ofrecer productos
        de calidad a nuestros clientes, brindando una
        experiencia de compra sencilla y confiable.
    </p>

</div>

<!-- MISIÓN Y VISIÓN -->
<div class="row g-4 mb-4">

    <!-- MISIÓN -->
    <div class="col-md-6">
        <div class="card h-100">

            <div class="card-body p-4">

                <div style="
                    background:#fff8e1;
                    width:55px;
                    height:55px;
                    border-radius:12px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:26px;
                ">
                    🎯
                </div>

                <h3 class="mt-4">Nuestra misión</h3>

                <p class="texto-secundario">
                    Ofrecer productos de calidad a nuestros
                    clientes, proporcionando una atención
                    eficiente y una experiencia de compra
                    agradable.
                </p>

            </div>

        </div>
    </div>

    <!-- VISIÓN -->
    <div class="col-md-6">
        <div class="card h-100">

            <div class="card-body p-4">

                <div style="
                    background:#eef2ff;
                    width:55px;
                    height:55px;
                    border-radius:12px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:26px;
                ">
                    ⭐
                </div>

                <h3 class="mt-4">Nuestra visión</h3>

                <p class="texto-secundario">
                    Ser una tienda reconocida por su
                    compromiso con la calidad, la confianza
                    y la satisfacción de nuestros clientes.
                </p>

            </div>

        </div>
    </div>

</div>

<!-- VALORES -->
<div class="seccion-tienda p-4 p-md-5">

    <span class="etiqueta">LO QUE NOS IDENTIFICA</span>

    <h2 class="mt-2 mb-4">Nuestros valores</h2>

    <div class="row g-4">

        <div class="col-md-4">
            <h5>✓ Responsabilidad</h5>
            <p class="texto-secundario">
                Cumplimos con nuestro compromiso de
                ofrecer un servicio de calidad.
            </p>
        </div>

        <div class="col-md-4">
            <h5>✓ Honestidad</h5>
            <p class="texto-secundario">
                Trabajamos con transparencia y
                confianza hacia nuestros clientes.
            </p>
        </div>

        <div class="col-md-4">
            <h5>✓ Atención</h5>
            <p class="texto-secundario">
                Escuchamos las necesidades de
                nuestros clientes para brindarles
                un mejor servicio.
            </p>
        </div>

    </div>

    <div class="text-center mt-4">
        <a href="{{ route('catalogo') }}"
           class="btn btn-tienda">
            Explorar productos →
        </a>
    </div>

</div>

@endsection
