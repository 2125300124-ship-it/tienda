
@extends('layouts.app')

@section('titulo', 'Contacto - Collector Store')

@section('contenido')

<!-- ENCABEZADO -->
<div class="seccion-tienda p-4 p-md-5 mb-4">

    <span class="etiqueta">CONTÁCTANOS</span>

    <h1 class="mt-3">Estamos para ayudarte</h1>

    <p class="texto-secundario mb-0">
        ¿Tienes alguna pregunta sobre nuestros productos?
        Puedes comunicarte con nosotros a través de
        nuestros medios de contacto.
    </p>

</div>

<div class="row g-4">

    <!-- INFORMACIÓN -->
    <div class="col-lg-5">

        <div class="card h-100">

            <div class="card-body p-4">

                <span class="etiqueta">INFORMACIÓN</span>

                <h3 class="mt-2 mb-4">
                    Medios de contacto
                </h3>

                <!-- CORREO -->
                <div class="d-flex align-items-start gap-3 mb-4">

                    <div style="
                        background:#fff8e1;
                        padding:12px;
                        border-radius:10px;
                        font-size:22px;
                    ">
                        ✉️
                    </div>

                    <div>
                        <h6 class="mb-1">Correo electrónico</h6>

                        <p class="texto-secundario mb-0">
                            contacto@mitienda.com
                        </p>
                    </div>

                </div>

                <!-- TELÉFONO -->
                <div class="d-flex align-items-start gap-3 mb-4">

                    <div style="
                        background:#ecfdf5;
                        padding:12px;
                        border-radius:10px;
                        font-size:22px;
                    ">
                        📞
                    </div>

                    <div>
                        <h6 class="mb-1">Teléfono</h6>

                        <p class="texto-secundario mb-0">
                            123 456 7890
                        </p>
                    </div>

                </div>

                <div class="alert border-0 rounded-3"
                     style="background:#fff8e1; color:#956400;">

                    Estamos disponibles para atender tus
                    dudas sobre nuestros productos.

                </div>

            </div>

        </div>

    </div>

    <!-- FORMULARIO -->
    <div class="col-lg-7">

        <div class="card h-100">

            <div class="card-body p-4">

                <span class="etiqueta">ENVÍANOS UN MENSAJE</span>

                <h3 class="mt-2 mb-4">
                    Formulario de contacto
                </h3>

                <form id="formContacto">

                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">
                            Nombre completo *
                        </label>

                        <input type="text"
                               class="form-control"
                               id="nombre"
                               name="nombre"
                               placeholder="Escribe tu nombre"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label fw-semibold">
                            Correo electrónico *
                        </label>

                        <input type="email"
                               class="form-control"
                               id="correo"
                               name="correo"
                               placeholder="ejemplo@correo.com"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="asunto" class="form-label fw-semibold">
                            Asunto *
                        </label>

                        <input type="text"
                               class="form-control"
                               id="asunto"
                               name="asunto"
                               placeholder="Motivo de tu mensaje"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="mensaje" class="form-label fw-semibold">
                            Mensaje *
                        </label>

                        <textarea class="form-control"
                                  id="mensaje"
                                  name="mensaje"
                                  rows="5"
                                  placeholder="Escribe tu mensaje..."
                                  required></textarea>
                    </div>

                    <button type="submit" class="btn btn-tienda w-100">
                        Enviar mensaje →
                    </button>

                </form>

                <p class="texto-secundario small mt-3 mb-0">
                    Formulario demostrativo. El envío de mensajes
                    se habilitará cuando configuremos su procesamiento.
                </p>

            </div>

        </div>

    </div>

</div>

<script>
    document.getElementById('formContacto').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Formulario de demostración. El mensaje todavía no se ha enviado.');
    });
</script>

@endsection
