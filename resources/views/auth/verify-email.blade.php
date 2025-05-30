<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Email - Burgers & Roll</title>
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/x-icon" />
    @vite(['resources/css/auth/verify-email.css'])
</head>
<body>
    <main>
        <div class="container">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo-img">
                <p class="title">Verificar Email</p>
            </div>
            
            @if (session('status') == 'verification-link-sent')
                <div class="message success">
                    Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.
                </div>
            @endif

            <p class="message">
                Gracias por registrarte. Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar?
            </p>
            
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="button">
                    Reenviar email de verificación
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="button">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </main>
    <footer>
        <p>© 2024 Burgers & Roll. Todos los derechos reservados.</p>
        <a href="{{ route('legal.aviso-legal') }}">Aviso Legal</a>
    </footer>
</body>
</html>
