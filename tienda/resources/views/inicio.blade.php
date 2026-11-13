
@extends('layouts.app')

@section('titulo', 'Inicio - Collector Store')

@section('contenido')

<!-- BIENVENIDA -->
<div class="seccion-tienda p-4 p-md-5 mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <span class="etiqueta">
                BIENVENIDO A NUESTRA TIENDA
            </span>

            <h1 class="display-5 fw-bold mt-3">
                Bienvenido a Collector Store
            </h1>

            <p class="fs-5 texto-secundario mt-3">
                Explora nuestro catálogo y descubre los
                productos que tenemos disponibles para ti.
            </p>

            <a href="{{ route('catalogo') }}"
               class="btn btn-tienda btn-lg mt-3">
                Ver catálogo →
            </a>

        </div>

        <div class="col-lg-4 text-center mt-4 mt-lg-0">

            <div style="
                background:#fff8e1;
                border-radius:20px;
                padding:45px;
                font-size:75px;
                color:#f5a400;
            ">
                ★
            </div>

        </div>

    </div>

</div>

<!-- SECCIÓN DE BENEFICIOS -->
<div class="mb-4">
    <span class="etiqueta">EXPLORA NUESTRA TIENDA</span>
    <h2 class="mt-2">¿Qué encontrarás aquí?</h2>
    <p class="texto-secundario">
        Descubre todo lo que Collector Store tiene para ofrecerte.
    </p>
</div>

<div class="row g-4">

    <!-- PRODUCTOS -->
    <div class="col-md-4">
        <div class="card h-100">

            <div class="card-body">

                <div style="
                    background:#fff8e1;
                    width:50px;
                    height:50px;
                    border-radius:12px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:25px;
                ">
                    📦
                </div>

                <h4 class="mt-4">Productos</h4>

                <p class="texto-secundario">
                    Consulta nuestro catálogo y encuentra
                    artículos disponibles en nuestra tienda.
                </p>

                <a href="{{ route('catalogo') }}"
                   class="text-decoration-none fw-bold"
                   style="color:#d99000">
                    Explorar →
                </a>

            </div>

        </div>
    </div>

    <!-- CALIDAD -->
    <div class="col-md-4">
        <div class="card h-100">

            <div class="card-body">

                <div style="
                    background:#eef2ff;
                    width:50px;
                    height:50px;
                    border-radius:12px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:25px;
                ">
                    ⭐
                </div>

                <h4 class="mt-4">Calidad</h4>

                <p class="texto-secundario">
                    Conoce nuestra selección de productos
                    y encuentra lo que estás buscando.
                </p>

                <a href="{{ route('nosotros') }}"
                   class="text-decoration-none fw-bold"
                   style="color:#d99000">
                    Conocer más →
                </a>

            </div>

        </div>
    </div>

    <!-- ATENCIÓN -->
    <div class="col-md-4">
        <div class="card h-100">

            <div class="card-body">

                <div style="
                    background:#ecfdf5;
                    width:50px;
                    height:50px;
                    border-radius:12px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:25px;
                ">
                    💬
                </div>

                <h4 class="mt-4">Atención</h4>

                <p class="texto-secundario">
                    ¿Tienes preguntas sobre nuestros
                    productos? Estamos para ayudarte.
                </p>

                <a href="{{ route('contacto') }}"
                   class="text-decoration-none fw-bold"
                   style="color:#d99000">
                    Contáctanos →
                </a>

            </div>

        </div>
    </div>

</div>

@endsection
