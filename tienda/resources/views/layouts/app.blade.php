
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('titulo', 'Collector Store')</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --amarillo: #f5a400;
            --amarillo-hover: #d99000;
            --fondo: #f1f5f9;
            --blanco: #ffffff;
            --texto: #0f172a;
            --gris: #64748b;
            --borde: #e2e8f0;
        }

        body {
            background-color: var(--fondo);
            color: var(--texto);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        main {
            flex: 1;
        }

        /* MENÚ PRINCIPAL */
        .navbar {
            background-color: var(--blanco);
            border-bottom: 1px solid var(--borde);
            padding: 12px 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        }

        .navbar-brand {
            font-size: 1.3rem;
            font-weight: 750;
            color: var(--texto);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand:hover {
            color: var(--texto);
        }

        .logo-icono {
            background-color: var(--amarillo);
            color: white;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            font-size: 22px;
        }

        .navbar .nav-link {
            color: #475569;
            font-size: 14px;
            font-weight: 600;
            margin-left: 12px;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: var(--amarillo-hover) !important;
        }

        /* OPCIONES DEL USUARIO */
        .navbar .nombre-usuario {
            color: var(--texto);
            font-size: 14px;
            font-weight: 700;
            margin-left: 12px;
        }

        .navbar .btn-registro {
            background-color: var(--amarillo);
            color: white !important;
            border-radius: 9px;
            padding: 9px 16px;
            font-weight: 600;
        }

        .navbar .btn-registro:hover {
            background-color: var(--amarillo-hover);
            color: white !important;
        }

        .navbar .btn-cerrar-sesion {
            color: #dc3545;
            cursor: pointer;
            font-family: inherit;
        }

        .navbar .btn-cerrar-sesion:hover {
            color: #b02a37 !important;
        }

        /* TARJETAS */
        .card,
        .seccion-tienda {
            background-color: white;
            border: 1px solid var(--borde);
            border-radius: 15px;
            box-shadow: 0 3px 8px rgba(15,23,42,0.03);
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(15,23,42,0.08);
        }

        .card-body {
            padding: 24px;
        }

        /* BOTONES */
        .btn-primary,
        .btn-warning,
        .btn-tienda {
            background-color: var(--amarillo);
            border: 1px solid var(--amarillo);
            color: white;
            font-weight: 600;
            border-radius: 9px;
            padding: 10px 20px;
        }

        .btn-primary:hover,
        .btn-warning:hover,
        .btn-tienda:hover {
            background-color: var(--amarillo-hover);
            border-color: var(--amarillo-hover);
            color: white;
        }

        .btn-outline-primary {
            color: var(--amarillo-hover);
            border-color: var(--amarillo);
        }

        .btn-outline-primary:hover {
            color: white;
            background-color: var(--amarillo);
            border-color: var(--amarillo);
        }

        /* TÍTULOS */
        h1, h2, h3, h4, h5 {
            color: var(--texto);
            font-weight: 700;
        }

        .texto-secundario {
            color: var(--gris);
        }

        .etiqueta {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #a36d00;
            text-transform: uppercase;
        }

        /* FORMULARIOS */
        .form-control {
            border: 1px solid var(--borde);
            border-radius: 9px;
            padding: 11px 14px;
        }

        .form-control:focus {
            border-color: var(--amarillo);
            box-shadow: 0 0 0 3px rgba(245,164,0,0.12);
        }

        /* PIE DE PÁGINA */
        footer {
            background-color: var(--blanco);
            border-top: 1px solid var(--borde);
            padding: 25px 0;
            margin-top: 40px;
            color: var(--gris);
        }
    </style>
</head>

<body>

    <!-- MENÚ PRINCIPAL -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">

            <div class="container">

                <!-- LOGO -->
                <a class="navbar-brand" href="{{ route('inicio') }}">
                    <span class="logo-icono">★</span>
                    Collector Store
                </a>

                <!-- BOTÓN PARA DISPOSITIVOS MÓVILES -->
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuPrincipal"
                    aria-controls="menuPrincipal"
                    aria-expanded="false"
                    aria-label="Abrir menú"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- ENLACES DE NAVEGACIÓN -->
                <div class="collapse navbar-collapse" id="menuPrincipal">

                    <ul class="navbar-nav ms-auto align-items-lg-center">

                        <!-- INICIO -->
                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}"
                                href="{{ route('inicio') }}"
                            >
                                Inicio
                            </a>
                        </li>

                        <!-- NOSOTROS -->
                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->routeIs('nosotros') ? 'active' : '' }}"
                                href="{{ route('nosotros') }}"
                            >
                                Nosotros
                            </a>
                        </li>

                        <!-- CATÁLOGO -->
                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->routeIs('catalogo') ? 'active' : '' }}"
                                href="{{ route('catalogo') }}"
                            >
                                Catálogo
                            </a>
                        </li>

                        <!-- CONTACTO -->
                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->routeIs('contacto') ? 'active' : '' }}"
                                href="{{ route('contacto') }}"
                            >
                                Contacto
                            </a>
                        </li>

                        <!-- CARRITO DE COMPRAS -->
                        <li class="nav-item">

                            @php
                                $cantidadCarrito = collect(
                                    session('carrito', [])
                                )->sum('cantidad');
                            @endphp

                            <a
                                class="nav-link {{ request()->routeIs('carrito.*') ? 'active' : '' }}"
                                href="{{ route('carrito.index') }}"
                            >
                                🛒 Carrito

                                <span
                                    class="badge rounded-pill"
                                    style="background:#f5a400; color:white;"
                                >
                                    {{ $cantidadCarrito }}
                                </span>
                            </a>

                        </li>

                        <!-- AUTENTICACIÓN DEL CLIENTE -->

                        @if(session('cliente_token') && session('cliente'))

                            @php
                                $clienteSesion = session('cliente', []);

                                $nombreCliente = is_array($clienteSesion)
                                    ? ($clienteSesion['nombres'] ?? 'Cliente')
                                    : 'Cliente';
                            @endphp

                            <!-- NOMBRE DEL CLIENTE -->
                            <li class="nav-item">

                                <span class="nav-link nombre-usuario">
                                    👤 {{ $nombreCliente }}
                                </span>

                            </li>

                            <!-- MI PERFIL -->
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('cliente.perfil*') ? 'active' : '' }}"
                                    href="{{ route('cliente.perfil') }}"
                                >
                                    Mi perfil
                                </a>

                            </li>

                            <!-- CERRAR SESIÓN -->
                            <li class="nav-item">

                                <form
                                    action="{{ route('cliente.logout') }}"
                                    method="POST"
                                    class="d-inline"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="nav-link btn-cerrar-sesion border-0 bg-transparent"
                                    >
                                        Cerrar sesión
                                    </button>

                                </form>

                            </li>

                        @else

                            <!-- INICIAR SESIÓN -->
                            <li class="nav-item">

                                <a
                                    class="nav-link {{ request()->routeIs('cliente.login') ? 'active' : '' }}"
                                    href="{{ route('cliente.login') }}"
                                >
                                    Iniciar sesión
                                </a>

                            </li>

                            <!-- REGISTRARSE -->
                            <li class="nav-item">

                                <a
                                    class="nav-link btn-registro {{ request()->routeIs('cliente.registro') ? 'active' : '' }}"
                                    href="{{ route('cliente.registro') }}"
                                >
                                    Registrarse
                                </a>

                            </li>

                        @endif

                    </ul>

                </div>

            </div>

        </nav>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container py-5">

        <!-- MENSAJE DE ÉXITO -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar"
                ></button>

            </div>
        @endif

        <!-- MENSAJE DE ERROR -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar"
                ></button>

            </div>
        @endif

        <!-- ERRORES DE VALIDACIÓN -->
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- CONTENIDO DE CADA PÁGINA -->
        @yield('contenido')

    </main>

    <!-- PIE DE PÁGINA -->
    <footer>

        <div class="container text-center">

            <h5 class="mb-2">
                ★ Collector Store
            </h5>

            <p class="mb-1">
                Tu tienda de productos y artículos de colección.
            </p>

            <small>
                Proyecto desarrollado con Laravel y Bootstrap
            </small>

            <p class="mt-2 mb-0">
                &copy; {{ date('Y') }} Collector Store.
                Todos los derechos reservados.
            </p>

        </div>

    </footer>

    <!-- JAVASCRIPT DE BOOTSTRAP -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>

</body>
</html>
