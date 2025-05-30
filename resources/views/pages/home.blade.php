@extends('layouts.app')

@section('content')
    <main>
        <section class="hero" style="background-image: url('{{ asset('images/home/banner.webp') }}');">
            <div class="hero__menu">
                <a href="{{ route('marketplace.menus') }}" class="hero__menu-item">MENÚS</a>
                <a href="{{ route('marketplace.burgers') }}" class="hero__menu-item">BURGERS</a>
                <a href="{{ route('marketplace.bebidas') }}" class="hero__menu-item">BEBIDAS</a>
                <a href="{{ route('marketplace.postres') }}" class="hero__menu-item">POSTRES</a>
            </div>
            <a href="{{ route('marketplace') }}" class="hero__cta">COMENZAR PEDIDO</a>
        </section>

        <section class="offers">
            <h2 class="offers__title">DESCUBRE NUESTRAS OFERTAS</h2>
            <div class="offers__grid">
                <a href="{{ route('marketplace.burgers') }}" class="offers__card">
                    <img src="{{ asset('images/home/burger.webp') }}" alt="BURGERS">
                    <h3>BURGERS</h3>
                </a>
                <a href="{{ route('marketplace.burgers') }}?filter=gluten-free" class="offers__card">
                    <img src="{{ asset('images/home/burger-sin-gluten.webp') }}" alt="BURGERS SIN GLUTEN">
                    <h3>BURGERS SIN GLUTEN</h3>
                </a>
                <a href="{{ route('marketplace.bebidas') }}" class="offers__card">
                    <img src="{{ asset('images/home/bebidas.webp') }}" alt="BEBIDAS">
                    <h3>BEBIDAS</h3>
                </a>
                <a href="{{ route('marketplace.menus') }}" class="offers__card">
                    <img src="{{ asset('images/home/menu.webp') }}" alt="MENÚS">
                    <h3>MENÚS</h3>
                </a>
            </div>
        </section>

        <section class="promo" style="background-image: url('{{ asset('images/home/offer.webp') }}');">
            <div class="promo__content">
                <div class="promo__text">
                    <span class="promo__number">2</span>
                    <h2 class="promo__title">HAMBURGESAS</h2>
                </div>
                <p class="promo__price">16<span>,90€</span></p>
            </div>
            <div class="promo__tag">¡SOLO EN TUS PEDIDOS WEB!</div>
        </section>

        <section class="location">
            <h2 class="location__title">¡Donde nos ubicamos!</h2>
            <div class="location__map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2993.6855503574644!2d2.1700124!3d41.3870145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4a2f286fc0f0d%3A0x4c0cd6b69af4ec86!2sPl.%20de%20Catalunya%2C%205%2C%20L&#39;Eixample%2C%2008002%20Barcelona!5e0!3m2!1ses!2ses!4v1710371245040!5m2!1ses!2ses"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </section>
    </main>
@endsection

@push('styles')
    @vite(['resources/css/pages/home.css'])
@endpush 