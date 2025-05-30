<footer class="w-full dark:bg-[#1A323E] bg-[#F3C71E] gap-5 flex flex-col justify-center items-center dark:text-white text-[#1A323E]">
  <div class="flex flex-col justify-center items-center gap-5 w-full p-5">
    <button class="dark:bg-white bg-[#1A323E] dark:text-[#1A323E] text-[#F3C71E] uppercase rounded-full py-2 px-10 shadow hover:shadow-md hover:opacity-90 transition-all duration-300">
      <a href="{{ route('marketplace.menus') }}" class="flex items-center gap-2">
        Ayuda
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 -rotate-90">
          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
      </a>
    </button>
    <div class="grid lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 justify-center items-start lg:gap-10 gap-5">
      <div class="flex flex-col justify-start">
        <h2 class="uppercase text-2xl">Productos</h2>
        <ul class="font-extralight">
          <li>
            <a href="{{ route('marketplace.menus') }}" class="hover:opacity-80 transition-all duration-300">
              Menús
            </a>
          </li>
          <li>
            <a href="{{ route('marketplace.burgers') }}" class="hover:opacity-80 transition-all duration-300">
              Burgers
            </a>
          </li>
          <li>
            <a href="{{ route('marketplace.bebidas') }}" class="hover:opacity-80 transition-all duration-300">
              Bebidas
            </a>
          </li>
          <li>
            <a href="{{ route('marketplace.postres') }}" class="hover:opacity-80 transition-all duration-300">
              Postres
            </a>
          </li>
        </ul>
      </div>

      <div class="flex flex-col justify-start">
        <h2 class="uppercase text-2xl">Nutrición y calidad</h2>
        <ul class="font-extralight">
          <li>
            <a href="#" class="hover:opacity-80 transition-all duration-300">
              Calidad y alimentación
            </a>
          </li>
          <li>
            <a href="#" class="hover:opacity-80 transition-all duration-300">
              Listado de alérgenos
            </a>
          </li>
          <li>
            <a href="#" class="hover:opacity-80 transition-all duration-300">
              Valores nutricionales
            </a>
          </li>
          <li>
            <a href="#" class="hover:opacity-80 transition-all duration-300">
              Tiendas para celíacos
            </a>
          </li>
          <li>
            <a href="#" class="hover:opacity-80 transition-all duration-300">
              Nuestras masas
            </a>
          </li>
          <li>
            <a href="#" class="hover:opacity-80 transition-all duration-300">
              Burgers sin gluten
            </a>
          </li>
        </ul>
      </div>

      <div class="flex flex-col justify-start">
        <h2 class="uppercase text-2xl">Corporativo</h2>
        <ul class="font-extralight">
          <li>
            <a href="#" class="hover:opacity-80 transition-all duration-300">
              Acerca de Burgers & Roll
            </a>
          </li>
          <li>
            <a href="#" class="hover:opacity-80 transition-all duration-300">
              Trabaja con nostros
            </a>
          </li>
          <li>
            <a href="#" class="hover:opacity-80 transition-all duration-300">
              Franquiciate
            </a>
          </li>
        </ul>
      </div>

      <div class="flex flex-col justify-start">
        <h2 class="uppercase text-2xl">Aviso legal</h2>
        <ul class="font-extralight">
          <li>
            <a target="_blank" href="{{ route('legal.aviso-legal') }}" class="hover:opacity-80 transition-all duration-300">
              Aviso legal
            </a>
          </li>
          <li>
            <a href="#" class="hover:opacity-80 transition-all duration-300">
              Condiciones generales
            </a>
          </li>
          <li>
            <a target="_blank" href="{{ route('legal.politica-privacidad') }}" class="hover:opacity-80 transition-all duration-300">
              Política de privacidad
            </a>
          </li>
          <li>
            <a target="_blank" href="{{ route('legal.cookies') }}" class="hover:opacity-80 transition-all duration-300">
              Política de cookies
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="flex flex-row justify-center items-center gap-5 dark:bg-white bg-[#1A323E] p-5 w-full">
    <a href="{{ route('marketplace.menus') }}"><img src="{{ asset('images/footer-logo.png') }}" alt="Burgers & Roll" class="w-12"></a>
    <a href="https://www.instagram.com/" target="_blank"><img src="{{ asset('images/insta.svg') }}" alt="Instagram" class="w-6 h-6 rounded"></a>
    <a href="https://www.facebook.com/" target="_blank"><img src="{{ asset('images/facebook.svg') }}" alt="Facebook" class="w-6 h-6 rounded"></a>
    <a href="https://www.youtube.com/" target="_blank"><img src="{{ asset('images/youtube.svg') }}" alt="Youtube" class="w-8 h-8 rounded"></a>
  </div>
</footer>
