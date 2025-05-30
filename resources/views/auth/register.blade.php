<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Burgers & Roll | Registrarse</title>
    <meta
      name="description"
      content="Registrarse en Burgers & Roll - Únete a nuestra familia y descubre nuestros productos"
    />
    <link
      rel="shortcut icon"
      href="{{ asset('images/icon.png') }}"
      type="image/x-icon"
    />
    @vite(['resources/css/auth/register.css', 'resources/js/auth/signUpValidation.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </head>
  <body>
    <main>
      <form
        class="form"
        role="form"
        action="{{ route('register') }}"
        method="POST"
        aria-label="Formulario de registro"
      >
        @csrf

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="logo">
          <img
            class="logo-img"
            src="{{ asset('images/logo.png') }}"
            title="Burgers & Roll"
            alt="logo"
          />
          <p class="title">Registrarse</p>
        </div>

        <div class="form-row">
          <label>
            <input
              class="input"
              id="nombre"
              name="nombre"
              type="text"
              required
              placeholder=""
              value="{{ old('nombre') }}"
            />
            <span>Nombre</span>
          </label>

          <label>
            <input
              class="input"
              id="apellidos"
              name="apellidos"
              type="text"
              required
              placeholder=""
              value="{{ old('apellidos') }}"
            />
            <span>Apellidos</span>
          </label>
        </div>

        <div class="form-row">
          <label>
            <input
              class="input"
              id="fecha_nacimiento"
              name="fecha_nacimiento"
              type="date"
              required
              placeholder=""
              value="{{ old('fecha_nacimiento') }}"
            />
            <span>Fecha de Nacimiento</span>
          </label>

          <label>
            <input
              class="input"
              id="telefono"
              name="telefono"
              type="tel"
              required
              placeholder=""
              value="{{ old('telefono') }}"
            />
            <span>Teléfono</span>
          </label>
        </div>

        <div class="form-column">
          <label>
            <input
              class="input"
              id="direccion_envio"
              name="direccion_envio"
              type="text"
              required
              placeholder=""
              value="{{ old('direccion_envio') }}"
            />
            <span>Dirección de Envío</span>
          </label>

          <label>
            <input
              class="input"
              id="direccion_facturacion"
              name="direccion_facturacion"
              type="text"
              required
              placeholder=""
              value="{{ old('direccion_facturacion') }}"
            />
            <span>Dirección de Facturación</span>
          </label>
        </div>

        <div class="checkbox">
          <input type="checkbox" id="reutilizar_direccion" name="reutilizar_direccion" />
          <label for="reutilizar_direccion">
            <span class="checkbox-text">Igual que dirección de envío</span>
          </label>
        </div>

        <label>
          <input
            class="input"
            id="email"
            name="email"
            type="email"
            required
            placeholder=""
            value="{{ old('email') }}"
          />
          <span>Email</span>
        </label>

        <div class="form-column">
          <label>
            <input
              class="input"
              id="password"
              name="password"
              type="password"
              required
              placeholder=""
            />
            <span>Contraseña</span>
          </label>

          <div class="password-strength">
            <meter id="password-strength" min="0" max="5" value="0" low="2" high="4" optimum="5"></meter>
            <span id="strength-text">Muy débil</span>
          </div>

          <label>
            <input
              class="input"
              id="password_confirmation"
              name="password_confirmation"
              type="password"
              required
              placeholder=""
            />
            <span>Confirmar Contraseña</span>
          </label>
        </div>

        <button class="submit">Registrarse</button>
        <p class="signup">
          ¿Ya tienes una cuenta?
          <a href="{{ route('login') }}">Inicia sesión</a>
        </p>
      </form>
    </main>
    <footer>
      <p>© 2024 Burgers & Roll. Todos los derechos reservados.</p>
      <a href="{{ route('legal.aviso-legal') }}">Aviso Legal</a>
    </footer>
  </body>
</html>
