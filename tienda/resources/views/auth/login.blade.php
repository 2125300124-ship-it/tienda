
@extends('layouts.app')

@section('titulo', 'Iniciar sesión - Collector Store')

@section('contenido')

<div class="row justify-content-center">

    <div class="col-md-7 col-lg-5">

        <div class="card shadow-sm">

            <div class="card-body p-4 p-md-5">

                <!-- ENCABEZADO -->
                <div class="text-center mb-4">

                    <span class="etiqueta">
                        COLLECTOR STORE
                    </span>

                    <h2 class="mt-2">
                        Iniciar sesión
                    </h2>

                    <p class="texto-secundario">
                        Accede a tu cuenta de Collector Store.
                    </p>

                </div>

                <!-- FORMULARIO -->
                <form action="{{ route('cliente.login.procesar') }}"
                      method="POST">

                    @csrf

                    <!-- CORREO -->
                    <div class="mb-3">

                        <label for="correo"
                               class="form-label fw-semibold">
                            Correo electrónico
                        </label>

                        <input type="email"
                               id="correo"
                               name="correo"
                               class="form-control @error('correo') is-invalid @enderror"
                               value="{{ old('correo') }}"
                               placeholder="ejemplo@correo.com"
                               autocomplete="email"
                               required>

                        @error('correo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- CONTRASEÑA -->
                    <div class="mb-4">

                        <label for="contrasena"
                               class="form-label fw-semibold">
                            Contraseña
                        </label>

                        <input type="password"
                               id="contrasena"
                               name="contraseña"
                               class="form-control @error('contraseña') is-invalid @enderror"
                               placeholder="Escribe tu contraseña"
                               autocomplete="current-password"
                               required>

                        @error('contraseña')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- BOTÓN -->
                    <button type="submit"
                            class="btn btn-tienda w-100">
                        Iniciar sesión
                    </button>

                </form>

                <hr class="my-4">

                <!-- REGISTRO -->
                <p class="text-center texto-secundario mb-0">

                    ¿Todavía no tienes cuenta?

                    <a href="{{ route('cliente.registro') }}"
                       class="fw-semibold text-decoration-none"
                       style="color:#d99000;">
                        Registrarse
                    </a>

                </p>

            </div>

        </div>

    </div>

</div>

@endsection
