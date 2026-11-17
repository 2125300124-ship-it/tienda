
@extends('layouts.app')

@section('titulo', 'Mi perfil - Collector Store')

@section('contenido')

<div class="row justify-content-center">

    <div class="col-lg-9">

        <div class="seccion-tienda p-4 p-md-5">

            <span class="etiqueta">
                MI CUENTA
            </span>

            <h1 class="mt-2 mb-4">
                Mi perfil
            </h1>

            <div class="row g-4 align-items-center">

                <!-- IMAGEN -->
                <div class="col-md-4 text-center">

                    @if(!empty($cliente['imagen']))
                        <img
                            src="{{ $cliente['imagen'] }}"
                            alt="Imagen de perfil"
                            class="rounded-circle border"
                            style="
                                width:180px;
                                height:180px;
                                object-fit:cover;
                            "
                        >
                    @else
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                             style="
                                width:180px;
                                height:180px;
                                background:#fff8e1;
                                color:#d99000;
                                font-size:75px;
                             ">
                            👤
                        </div>
                    @endif

                <!-- FORMULARIO PARA CAMBIAR FOTOGRAFÍA -->
                <form action="{{ route('cliente.perfil.imagen') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="mt-3">

                    @csrf

                    <label for="imagen" class="form-label fw-semibold">
                        Cambiar fotografía
                    </label>

                    <input type="file"
                        name="imagen"
                        id="imagen"
                        class="form-control @error('imagen') is-invalid @enderror"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        required>

                    @error('imagen')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="text-muted d-block mt-2">
                        JPG, PNG o WEBP. Máximo 2 MB.
                    </small>

                    <button type="submit"
                            class="btn btn-tienda mt-3 w-100">
                        Guardar fotografía
                    </button>

                </form>


                </div>

                <!-- INFORMACIÓN -->
                <div class="col-md-8">

                    <h2>
                        {{ $cliente['nombres'] }}
                        {{ $cliente['apellidos'] }}
                    </h2>

                    <hr>

                    <p>
                        <strong>Correo electrónico:</strong>
                        {{ $cliente['correo'] }}
                    </p>

                    <p>
                        <strong>Teléfono:</strong>
                        {{ $cliente['telefono'] ?? 'No registrado' }}
                    </p>

                    <p>
                        <strong>Dirección:</strong>
                        {{ $cliente['direccion'] ?? 'No registrada' }}
                    </p>



<!-- EDITAR DATOS PERSONALES -->
<div class="mt-4">

    <h3 class="mb-3">Editar mis datos</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('cliente.perfil.actualizar') }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Nombre(s)</label>
                <input type="text"
                       name="nombres"
                       class="form-control @error('nombres') is-invalid @enderror"
                       value="{{ old('nombres', $cliente['nombres']) }}"
                       required>
                @error('nombres')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Apellidos</label>
                <input type="text"
                       name="apellidos"
                       class="form-control @error('apellidos') is-invalid @enderror"
                       value="{{ old('apellidos', $cliente['apellidos']) }}"
                       required>
                @error('apellidos')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <label class="form-label">Correo electrónico</label>
                <input type="email"
                       name="correo"
                       class="form-control @error('correo') is-invalid @enderror"
                       value="{{ old('correo', $cliente['correo']) }}"
                       required>
                @error('correo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text"
                       name="telefono"
                       class="form-control @error('telefono') is-invalid @enderror"
                       value="{{ old('telefono', $cliente['telefono'] ?? '') }}">
                @error('telefono')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Dirección</label>
                <input type="text"
                       name="direccion"
                       class="form-control @error('direccion') is-invalid @enderror"
                       value="{{ old('direccion', $cliente['direccion'] ?? '') }}">
                @error('direccion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <button type="submit"
                class="btn btn-tienda mt-4">
            Guardar cambios
        </button>

    </form>


<!-- CAMBIAR CONTRASEÑA -->
<div class="mt-5 pt-4 border-top">

    <h3 class="mb-3">Cambiar contraseña</h3>

    <p class="text-muted">
        Por seguridad, escribe tu contraseña actual antes de
        establecer una nueva.
    </p>

    <form action="{{ route('cliente.perfil.password') }}"
          method="POST">

        @csrf
        @method('PUT')

        <!-- CONTRASEÑA ACTUAL -->
        <div class="mb-3">
            <label for="password_actual" class="form-label">
                Contraseña actual
            </label>

            <input type="password"
                   name="password_actual"
                   id="password_actual"
                   class="form-control @error('password_actual', 'password') is-invalid @enderror"
                   autocomplete="current-password"
                   required>

            @error('password_actual', 'password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- NUEVA CONTRASEÑA -->
        <div class="mb-3">
            <label for="password_nuevo" class="form-label">
                Nueva contraseña
            </label>

            <input type="password"
                   name="password_nuevo"
                   id="password_nuevo"
                   class="form-control @error('password_nuevo', 'password') is-invalid @enderror"
                   autocomplete="new-password"
                   minlength="8"
                   required>

            @error('password_nuevo', 'password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            <small class="text-muted">
                Mínimo 8 caracteres, con mayúsculas, minúsculas y números.
            </small>
        </div>

        <!-- CONFIRMAR CONTRASEÑA -->
        <div class="mb-3">
            <label for="password_nuevo_confirmation" class="form-label">
                Confirmar nueva contraseña
            </label>

            <input type="password"
                   name="password_nuevo_confirmation"
                   id="password_nuevo_confirmation"
                   class="form-control"
                   autocomplete="new-password"
                   minlength="8"
                   required>
        </div>

        <button type="submit" class="btn btn-tienda">
            Actualizar contraseña
        </button>

    </form>


<!-- CERRAR SESIÓN -->
<div class="mt-5 pt-4 border-top">

    <h3 class="mb-3">Cerrar sesión</h3>

    <p class="text-muted">
        Puedes cerrar tu sesión de forma segura.
        Los productos de tu carrito se conservarán.
    </p>

    <form action="{{ route('cliente.logout') }}"
          method="POST">

        @csrf

        <button type="submit"
                class="btn btn-outline-danger">
            Cerrar sesión
        </button>

    </form>

</div>


</div>


@endsection
