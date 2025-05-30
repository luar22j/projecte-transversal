<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Burgers & Roll | Aviso Legal</title>
    <meta name="description" content="Aviso Legal de Burgers & Roll" />
    <link
      rel="shortcut icon"
      href="{{ asset('images/icon.png') }}"
      type="image/x-icon"
    />
    @vite(['resources/css/legal/aviso-legal.css'])
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
        <h1 class="title">Aviso Legal</h1>
      </header>

      <main>
        <section>
          <h2 class="title">Información General</h2>
          <p>
            En cumplimiento con el deber de información dispuesto en la Ley
            34/2002 de Servicios de la Sociedad de la Información y el Comercio
            Electrónico (LSSI-CE), se facilitan a continuación los siguientes
            datos de información general de este sitio web:
          </p>
          <p>
            La titularidad de este sitio web corresponde a: Burgers & Roll
            S.L.<br />
            NIF: B12345678<br />
            Domicilio: Pl. de Catalunya, 5, L'Eixample, 08002 Barcelona
          </p>
        </section>

        <section>
          <h2 class="title">Términos y Condiciones de Uso</h2>
          <p>
            El acceso y uso de este sitio web implica la aceptación expresa y
            sin reservas de todos los términos y condiciones incluidos en este
            Aviso Legal.
          </p>
        </section>

        <section>
          <h2 class="title">Propiedad Intelectual</h2>
          <p>
            Los derechos de propiedad intelectual del contenido de las páginas
            web, su diseño gráfico y códigos son titularidad de Burgers & Roll
            S.L. y, por tanto, queda prohibida su reproducción, distribución,
            comunicación pública y transformación, salvo para uso personal y
            privado.
          </p>
        </section>

        <section>
          <h2 class="title">Responsabilidad</h2>
          <p>
            Burgers & Roll S.L. no se hace responsable de los daños y perjuicios
            que se pudieran derivar de interferencias, omisiones,
            interrupciones, virus informáticos, averías telefónicas o
            desconexiones en el funcionamiento operativo de este sistema
            electrónico.
          </p>
        </section>

        <section>
          <h2 class="title">Legislación Aplicable</h2>
          <p>
            Las presentes condiciones se rigen por la legislación española. Para
            cualquier litigio que pudiera surgir relacionado con el sitio web o
            la actividad que en él se desarrolla serán competentes los Juzgados
            y Tribunales de Barcelona.
          </p>
        </section>

        <section>
          <h2 class="title">Contacto</h2>
          <p>
            Para cualquier consulta relacionada con este aviso legal, puede
            contactarnos en:
            <a href="mailto:legal@burgersandroll.com"
              >legal@burgersandroll.com</a
            >
          </p>
        </section>
      </main>

      <footer>
        <p>© 2024 Burgers & Roll. Todos los derechos reservados.</p>
      </footer>
    </div>
  </body>
</html>
