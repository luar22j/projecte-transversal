<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Burgers & Roll | Política de Privacidad</title>
    <meta
      name="description"
      content="Política de Privacidad de Burgers & Roll"
    />
    <link
      rel="shortcut icon"
      href="{{ asset('images/icon.png') }}"
      type="image/x-icon"
    />
    @vite(['resources/css/legal/politica-privacidad.css'])
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
        <h1 class="title">Política de Privacidad</h1>
      </header>

      <main>
        <section>
          <h2 class="title">Información que Recopilamos</h2>
          <p>
            En Burgers & Roll recopilamos la siguiente información personal:
          </p>
          <ul>
            <li>Nombre y apellidos</li>
            <li>Dirección de correo electrónico</li>
            <li>Dirección de entrega</li>
            <li>Preferencias de pedidos</li>
            <li>Historial de compras</li>
          </ul>
        </section>

        <section>
          <h2 class="title">Uso de la Información</h2>
          <p>Utilizamos su información personal para:</p>
          <ul>
            <li>Procesar y entregar sus pedidos</li>
            <li>Enviar comunicaciones sobre su cuenta y pedidos</li>
            <li>Mejorar nuestros productos y servicios</li>
            <li>Personalizar su experiencia</li>
            <li>
              Enviar promociones y ofertas especiales (con su consentimiento)
            </li>
          </ul>
        </section>

        <section>
          <h2 class="title">Protección de Datos</h2>
          <p>
            Implementamos medidas de seguridad técnicas y organizativas para
            proteger su información personal contra acceso no autorizado,
            pérdida o alteración.
          </p>
        </section>

        <section>
          <h2 class="title">Sus Derechos</h2>
          <p>Usted tiene derecho a:</p>
          <ul>
            <li>Acceder a sus datos personales</li>
            <li>Rectificar datos inexactos</li>
            <li>Solicitar la eliminación de sus datos</li>
            <li>Oponerse al procesamiento de sus datos</li>
            <li>Retirar su consentimiento en cualquier momento</li>
          </ul>
        </section>

        <section>
          <h2 class="title">Compartir Información</h2>
          <p>
            No vendemos ni compartimos su información personal con terceros,
            excepto cuando es necesario para proporcionar nuestros servicios o
            cuando la ley lo requiere.
          </p>
        </section>

        <section>
          <h2 class="title">Contacto</h2>
          <p>
            Para cualquier consulta sobre nuestra política de privacidad, puede
            contactarnos en:
            <a href="mailto:privacidad@burgersandroll.com"
              >privacidad@burgersandroll.com</a
            >
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
