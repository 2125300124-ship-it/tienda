
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Collector Store')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

        /* TARJETAS */
        .card, .seccion-tienda {
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
        .btn-primary, .btn-warning, .btn-tienda {
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

    <!-- MENÚ -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">

                <a class="navbar-brand" href="{{ route('inicio') }}">
                    <span class="logo-icono">★</span>
                    Collector Store
                </a>

                <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuPrincipal"
                    aria-controls="menuPrincipal"
                    aria-expanded="false"
                    aria-label="Abrir menú">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="menuPrincipal">
                    <ul class="navbar-nav ms-auto align-items-lg-center">

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('inicio') ? 'active' : '' }}"
                               href="{{ route('inicio') }}">
                                Inicio
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('nosotros') ? 'active' : '' }}"
                               href="{{ route('nosotros') }}">
                                Nosotros
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('catalogo') ? 'active' : '' }}"
                               href="{{ route('catalogo') }}">
                                Catálogo
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contacto') ? 'active' : '' }}"
                               href="{{ route('contacto') }}">
                                Contacto
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- CONTENIDO -->
    <main class="container py-5">
        @yield('contenido')
    </main>

    <!-- PIE DE PÁGINA -->
    <footer>
        <div class="container text-center">
            <h5 class="mb-2">★ Collector Store</h5>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
