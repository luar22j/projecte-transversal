<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Burgers & Roll | Contacto</title>
    <meta name="description" content="Contacta con Burgers & Roll - Resolvemos tus dudas sobre nuestros productos" />
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/x-icon" />
    @vite(['resources/css/pages/contacto.css', 'resources/js/pages/contacto.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <main>
        <form class="form" role="form" action="{{ route('contact.send') }}" method="POST" aria-label="Formulario de contacto">
            @csrf
            <div class="logo">
                <img class="logo-img" src="{{ asset('images/logo.png') }}" title="Burgers & Roll" alt="logo" />
                <p class="title">Contacto</p>
            </div>

            @guest
            <div class="form-row">
                <label>
                    <input class="input" id="nombre" name="nombre" type="text" required placeholder="" />
                    <span>Nombre</span>
                </label>

                <label>
                    <input class="input" id="apellidos" name="apellidos" type="text" required placeholder="" />
                    <span>Apellidos</span>
                </label>
            </div>

            <label>
                <input class="input" id="email" name="email" type="email" required placeholder="" />
                <span>Email</span>
            </label>
            @endguest

            <label>
                <input class="input" id="producto" name="producto" type="text" required placeholder="" />
                <span>Producto (nombre o referencia)</span>
            </label>

            <div class="form-group">
                <label>
                    <textarea class="input" id="consulta" name="consulta" required placeholder="" maxlength="150"></textarea>
                    <span>Consulta</span>
                </label>
                <div class="char-counter">
                    <span id="char-count">0</span>/150
                </div>
            </div>

            <div class="spinner-container" style="display: none;">
                <div class="spinner"></div>
            </div>

            <button class="submit" type="submit" disabled>Enviar consulta</button>
        </form>
    </main>
    <footer>
        <p>© 2024 Burgers & Roll. Todos los derechos reservados.</p>
        <a href="{{ route('legal.aviso-legal') }}">Aviso Legal</a>
    </footer>
</body>
</html> 