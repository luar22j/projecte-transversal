@vite(['resources/js/components/navigation.js', 'resources/css/components/navigation.css'])

<nav class="flex flex-col md:flex-row items-center justify-center gap-4 m-3 md:m-5 animate-fadeIn">
  <div class="w-full md:w-auto flex justify-center items-center bg-[#F3C71E] rounded-full shadow-md overflow-x-auto">
    <div class="flex flex-nowrap font-bold gap-2 justify-center items-center p-2 mx-auto md:mx-0 md:px-10 min-w-full md:min-w-0">
      <a href="{{ route('marketplace.menus') }}" 
          class="nav-link {{ request()->routeIs('marketplace.menus') ? 'bg-[#1A323E] text-white' : 'text-[#1A323E]' }} 
          flex items-center px-2 py-1 md:px-4 md:py-2 rounded-full text-sm md:text-base whitespace-nowrap uppercase">
          Menús
      </a>
      <a href="{{ route('marketplace.burgers') }}" 
          class="nav-link {{ request()->routeIs('marketplace.burgers') ? 'bg-[#1A323E] text-white' : 'text-[#1A323E]' }} 
          flex items-center px-2 py-1 md:px-4 md:py-2 rounded-full text-sm md:text-base whitespace-nowrap uppercase"
          id="burgers-link">
          Burgers
      </a>
      <a href="{{ route('marketplace.bebidas') }}" 
          class="nav-link {{ request()->routeIs('marketplace.bebidas') ? 'bg-[#1A323E] text-white' : 'text-[#1A323E]' }} 
          flex items-center px-2 py-1 md:px-4 md:py-2 rounded-full text-sm md:text-base whitespace-nowrap uppercase">
        Bebidas
      </a>  
      <a href="{{ route('marketplace.postres') }}" 
          class="nav-link {{ request()->routeIs('marketplace.postres') ? 'bg-[#1A323E] text-white' : 'text-[#1A323E]' }} 
          flex items-center px-2 py-1 md:px-4 md:py-2 rounded-full text-sm md:text-base whitespace-nowrap uppercase">
        Postres
      </a>
    </div>
  </div>

  <!-- Buscador -->
  @unless(request()->routeIs('marketplace'))
  <div class="w-full md:w-auto flex justify-center items-center mb-4 md:mb-0">
    <div class="relative w-full md:w-64">
      <input type="text" 
             id="productSearch" 
             placeholder="Buscar producto..." 
             class="w-full px-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:border-[#1A323E] focus:ring-1 focus:ring-[#1A323E] transition-all duration-300"
      >
      <button id="clearSearch" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-[#1A323E] transition-colors hidden">
        <i class="fas fa-times"></i>
      </button>
      <button id="searchIcon" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-[#1A323E] transition-colors">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>
  @endunless
</nav>