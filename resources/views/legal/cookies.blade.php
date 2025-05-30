<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Burgers & Roll | Política de Cookies</title>
    <meta name="description" content="Política de Cookies de Burgers & Roll" />
    <link
      rel="shortcut icon"
      href="{{ asset('images/icon.png') }}"
      type="image/x-icon"
    />
    @vite(['resources/css/legal/cookies.css'])
  </head>
  <body>
    <div class="container">
      <header>
        <img
          class="logo"
          title="Burgers & Roll"
          src="{{ asset('images/logo.png') }}"
          alt="Logo de Burgers & Roll"
        />
        <h1 class="title">Política de Cookies</h1>
      </header>

      <main>
        <section>
          <h2 class="title">¿Qué son las cookies?</h2>
          <p>
            Las cookies son pequeños archivos de texto que se almacenan en su
            dispositivo cuando visita un sitio web. Se utilizan para recordar
            sus preferencias y mejorar su experiencia de navegación.
          </p>
        </section>

        <section>
          <h2 class="title">¿Cómo utilizamos las cookies?</h2>
          <p>En Burgers & Roll, utilizamos cookies para:</p>
          <ul>
            <li>Recordar sus preferencias de usuario.</li>
            <li>Analizar el tráfico de nuestro sitio web.</li>
            <li>Ofrecer contenido personalizado.</li>
          </ul>
        </section>

        <section>
          <h2 class="title">Tipos de cookies que utilizamos</h2>
          <ul>
            <li>
              <strong>Cookies esenciales:</strong> Necesarias para el
              funcionamiento del sitio web.
            </li>
            <li>
              <strong>Cookies de análisis:</strong> Nos ayudan a mejorar nuestro
              sitio web al recopilar información sobre su uso.
            </li>
            <li>
              <strong>Cookies de publicidad:</strong> Utilizadas para mostrar
              anuncios relevantes para usted.
            </li>
          </ul>
        </section>

        <section>
          <h2 class="title">Gestión de cookies</h2>
          <p>
            Puede gestionar sus preferencias de cookies a través de la
            configuración de su navegador. Tenga en cuenta que deshabilitar
            cookies puede afectar su experiencia en nuestro sitio web.
          </p>
        </section>

        <section>
          <h2 class="title">Más información</h2>
          <p>
            Para obtener más información sobre nuestra política de cookies,
            puede contactarnos en
            <a href="mailto:info@burgersandroll.com">info@burgersandroll.com</a
            >.
          </p>
        </section>
      </main>

      <footer>
        <p>© 2024 Burgers & Roll. Todos los derechos reservados.</p>
        <a href="{{ route('legal.aviso-legal') }}">Aviso Legal</a>
      </footer>
    </div>
  </body>
</html>
