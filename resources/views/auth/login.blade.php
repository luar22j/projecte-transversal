<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Burgers & Roll | Iniciar sesión</title>
    <meta
      name="description"
      content="Iniciar sesión en Burgers & Roll - Accede a tu cuenta y disfruta de nuestros productos"
    />
    <link
      rel="shortcut icon"
      href="{{ asset('images/icon.png') }}"
      type="image/x-icon"
    />
    @vite(['resources/css/auth/login.css', 'resources/js/auth/signInValidation.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </head>
  <body>
    <main>
      <form
        class="form"
        role="form"
        action="{{ route('login') }}"
        method="POST"
        aria-label="Formulario de inicio de sesión"
      >
        @csrf
        <div class="logo">
          <img
            class="logo-img"
            src="{{ asset('images/logo.png') }}"
            title="Burgers & Roll"
            alt="logo"
          />
          <p class="title">Iniciar sesión</p>
        </div>

        <label>
          <input
            class="input"
            id="email"
            name="email"
            type="email"
            required
            placeholder=""
          />
          <span>Dirección de correo electrónico</span>
        </label>

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

        <div class="checkbox">
          <input type="checkbox" id="checkbox" name="remember" />
          <label for="checkbox">
            <span class="checkbox-text">Recordar mis datos</span>
          </label>
        </div>

        <button class="submit">Iniciar sesión</button>
        <p class="signup">
          ¿Aún no formas parte de nuestra familia?
          <a href="{{ route('register') }}">Registrate</a>
        </p>
      </form>
    </main>
    <footer>
      <p>© 2024 Burgers & Roll. Todos los derechos reservados.</p>
      <a href="{{ route('legal.aviso-legal') }}">Aviso Legal</a>
    </footer>
  </body>
</html>
