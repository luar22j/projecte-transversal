<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Burgers & Roll | Quienes Somos - Historia y Valores</title>
    <meta name="description" content="Descubre la historia de Burgers & Roll, tu restaurante de hamburguesas artesanales en Barcelona. Conoce nuestra misión, valores y propuesta gastronómica única.">
    <meta name="keywords" content="Burgers & Roll, hamburguesas artesanales, Barcelona, delivery, gastronomía, restaurante, historia, valores, misión">
    <meta name="author" content="Burgers & Roll">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Burgers & Roll | Quienes Somos">
    <meta property="og:description" content="Descubre la historia de Burgers & Roll, tu restaurante de hamburguesas artesanales en Barcelona.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite([
        'resources/css/app.css',
        'resources/css/marketplace/nav.css',
        'resources/css/font/font.css'
    ])
    <link
        rel="shortcut icon"
        href="{{ asset('images/icon.png') }}"
        type="image/x-icon"
    />
</head>
<body class="bg-[#1A323E]">
    @include('components.header')
    
    <main class="container mx-auto px-4 max-w-7xl">
        <article itemscope itemtype="http://schema.org/AboutPage">
            <h1 class="text-5xl font-bold text-center mb-12 relative">
                <span class="relative inline-block after:content-[''] after:absolute after:-bottom-4 after:left-0 after:w-full after:h-1 after:bg-[#F3C71E]">Quiénes Somos</span>
            </h1>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <figure class="video-container relative" aria-label="Video promocional de Burgers & Roll">
                    <div id="videoLoader" class="absolute inset-0 flex items-center justify-center bg-[#1A323E]/80 z-10 m-4 rounded-lg">
                        <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-[#F3C71E]" role="status" aria-label="Cargando video">
                            <span class="sr-only">Cargando video...</span>
                        </div>
                    </div>
                    <video 
                        class="w-full h-auto rounded-lg"
                        controls
                        autoplay
                        muted
                        loop
                        poster="{{ asset('images/icon.png') }}"
                        title="Video promocional de Burgers & Roll"
                        onloadeddata="document.getElementById('videoLoader').style.display = 'none'"
                    >
                        <source src="{{ asset('videos/burgers_and_roll.webm') }}" type="video/webm">
                        Tu navegador no soporta el formato de vídeo.
                    </video>
                </figure>
                
                <div class="content space-y-8 bg-[#FAFAEC] rounded-xl p-8 shadow-xl">
                    <section class="historia" itemscope itemtype="http://schema.org/Organization">
                        <h2 class="text-3xl font-semibold mb-4 text-[#1A323E] flex items-center">
                            <i class="fas fa-book-open mr-3 text-[#F3C71E]" aria-hidden="true"></i>
                            Nuestra Historia
                        </h2>
                        <p class="text-lg text-[#1A323E]/80 leading-relaxed" itemprop="description">
                            En Burgers & Roll, nacimos con una pasión: crear las mejores hamburguesas artesanales de Barcelona. Nuestra aventura comenzó con la idea de llevar la alta gastronomía directamente a tu casa, combinando ingredientes de primera calidad con un servicio excepcional.
                        </p>
                    </section>
                    
                    <section class="missio">
                        <h2 class="text-3xl font-semibold mb-4 text-[#1A323E] flex items-center">
                            <i class="fas fa-bullseye mr-3 text-[#F3C71E]" aria-hidden="true"></i>
                            Nuestra Misión
                        </h2>
                        <p class="text-lg text-[#1A323E]/80 leading-relaxed">
                            Nuestra misión es ofrecer una experiencia gastronómica única, llevando hamburguesas gourmet directamente a la puerta de tu casa. Nos distinguimos por la posibilidad de personalizar completamente tu hamburguesa, permitiéndote crear combinaciones únicas que se adapten a tus gustos.
                        </p>
                    </section>
                    
                    <section class="valors">
                        <h2 class="text-3xl font-semibold mb-4 text-[#1A323E] flex items-center">
                            <i class="fas fa-star mr-3 text-[#F3C71E]" aria-hidden="true"></i>
                            Nuestros Valores
                        </h2>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-4" role="list">
                            <li class="flex items-start space-x-2 bg-white/50 p-4 rounded-lg border border-[#F3C71E]/20 hover:border-[#F3C71E]/50 transition-colors duration-300" role="listitem">
                                <i class="fas fa-check-circle text-[#F3C71E] mt-1" aria-hidden="true"></i>
                                <span class="text-[#1A323E]/80">Calidad Premium: Utilizamos solo ingredientes frescos y de primera calidad</span>
                            </li>
                            <li class="flex items-start space-x-2 bg-white/50 p-4 rounded-lg border border-[#F3C71E]/20 hover:border-[#F3C71E]/50 transition-colors duration-300" role="listitem">
                                <i class="fas fa-check-circle text-[#F3C71E] mt-1" aria-hidden="true"></i>
                                <span class="text-[#1A323E]/80">Personalización: Cada cliente puede crear su hamburguesa ideal</span>
                            </li>
                            <li class="flex items-start space-x-2 bg-white/50 p-4 rounded-lg border border-[#F3C71E]/20 hover:border-[#F3C71E]/50 transition-colors duration-300" role="listitem">
                                <i class="fas fa-check-circle text-[#F3C71E] mt-1" aria-hidden="true"></i>
                                <span class="text-[#1A323E]/80">Servicio Excelente: Garantizamos una entrega rápida y precisa</span>
                            </li>
                            <li class="flex items-start space-x-2 bg-white/50 p-4 rounded-lg border border-[#F3C71E]/20 hover:border-[#F3C71E]/50 transition-colors duration-300" role="listitem">
                                <i class="fas fa-check-circle text-[#F3C71E] mt-1" aria-hidden="true"></i>
                                <span class="text-[#1A323E]/80">Innovación: Constantemente desarrollamos nuevas recetas</span>
                            </li>
                            <li class="flex items-start space-x-2 bg-white/50 p-4 rounded-lg border border-[#F3C71E]/20 hover:border-[#F3C71E]/50 transition-colors duration-300 md:col-span-2" role="listitem">
                                <i class="fas fa-check-circle text-[#F3C71E] mt-1" aria-hidden="true"></i>
                                <span class="text-[#1A323E]/80">Compromiso Local: Trabajamos con proveedores locales de Barcelona</span>
                            </li>
                        </ul>
                    </section>

                    <section class="proposta">
                        <h2 class="text-3xl font-semibold mb-4 text-[#1A323E] flex items-center">
                            <i class="fas fa-lightbulb mr-3 text-[#F3C71E]" aria-hidden="true"></i>
                            Nuestra Propuesta
                        </h2>
                        <div class="bg-gradient-to-r from-white/50 to-[#F3C71E]/10 p-6 rounded-lg border border-[#F3C71E]/20">
                            <p class="text-lg text-[#1A323E]/80 leading-relaxed">
                                En Burgers & Roll, cada hamburguesa es una obra maestra. Desde nuestras creaciones signature hasta la opción de personalizar completamente tu hamburguesa, ofrecemos una experiencia única en el mundo del delivery. Situada en el corazón de Barcelona, nuestra cocina está equipada con la mejor tecnología para garantizar que cada pedido llegue en perfectas condiciones.
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </article>
    </main>

    @include('components.footer')
</body>
</html>