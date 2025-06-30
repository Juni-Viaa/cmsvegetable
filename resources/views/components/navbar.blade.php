<script src="https://unpkg.com/alpinejs" defer></script>
<style>
  [x-cloak] { display: none !important; }
</style>

@php
    $productsActive = request()->routeIs('products', 'list_product');
    $blogActive = request()->routeIs('blog', 'list_blog');

    $productsLabel = request()->routeIs('list_product') ? 'List Product' : 'Products';
    $blogLabel = request()->routeIs('list_blog') ? 'List Blog' : 'Blog';
@endphp

<!-- Navbar -->
<nav x-data="navComponent" x-init="init()"
     class="relative w-full flex flex-wrap items-center justify-between px-6 py-4 gap-y-3 bg-white shadow z-50">

  <!-- Logo -->
  <div class="flex items-center gap-3">
    <a href="{{ route('front.index') }}" class="flex items-center gap-3 hover:opacity-80">
      <img src="{{ asset('images/logo.png') }}" class="h-[43px] w-auto object-contain" alt="Logo">
      <div>
        <p class="font-extrabold text-xl text-black">SayurKita</p>
        <p class="text-sm text-black">Vegetable Revolution</p>
      </div>
    </a>
  </div>

  <!-- Navigasi Desktop -->
  <ul class="hidden md:flex absolute left-1/2 -translate-x-1/2 gap-8 font-semibold text-black">
    <template x-for="item in navItems" :key="item.name">
      <li x-data="{ open: false }" class="relative">
        <template x-if="item.dropdown">
          <div>
            <button @click="open = !open" type="button"
              :class="{ 'text-blue-700 font-bold': open || item.active }"
              class="flex items-center gap-1 transition hover:text-blue-700">
              <span x-text="item.label"></span>
              <svg class="w-4 h-4 transform transition-transform duration-300"
                   :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                   viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6" />
              </svg>
            </button>
            <div x-show="open" x-cloak @click.outside="open = false" x-transition
                 class="absolute top-full mt-2 w-48 bg-white border rounded shadow-lg z-50">
              <template x-for="sub in item.dropdown" :key="sub.label">
                <a :href="sub.href"
                   :class="sub.active ? 'text-blue-700 font-semibold' : ''"
                   class="block px-4 py-2 text-sm transition hover:bg-gray-100 hover:text-blue-700">
                  <span x-text="sub.label"></span>
                </a>
              </template>
            </div>
          </div>
        </template>
        <template x-if="!item.dropdown">
          <a :href="item.href"
             :class="item.active ? 'text-blue-700 font-semibold' : ''"
             class="transition hover:text-blue-700">
            <span x-text="item.label"></span>
          </a>
        </template>
      </li>
    </template>
  </ul>

  <!-- Kanan: Avatar + Setting + Toggle Mobile -->
  <div class="flex items-center gap-4">
    <div class="flex items-center gap-3 relative" x-data="{ open: false }">
      <img src="https://ui-avatars.com/api/?name=User&background=random&color=fff"
           alt="User Avatar" class="w-8 h-8 rounded-full object-cover" />
      <button @click="open = !open" class="hover:text-blue-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="3" />
          <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33
                   1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51
                   1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06
                   a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09
                   a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06
                   a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.09
                   a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h.09
                   a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06
                   a1.65 1.65 0 0 0-.33 1.82v.09a1.65 1.65 0 0 0 1.51 1H21
                   a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
        </svg>
      </button>
      <div x-show="open" x-cloak @click.outside="open = false" x-transition
           class="absolute right-0 top-full mt-2 w-48 bg-white border rounded shadow-lg z-50">
        <a href="{{ route('settings.index') }}"
           class="block px-4 py-2 text-sm text-black hover:bg-gray-100 hover:text-blue-700 font-semibold">
          Setting Akun
        </a>
        <div class="border-t my-1"></div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="w-full text-left px-4 py-2 text-sm text-black hover:bg-gray-100 hover:text-red-600 font-semibold">
            Log Out
          </button>
        </form>
      </div>
    </div>

    <!-- Toggle Mobile Menu -->
    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden">
      <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
      <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
           viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>

  <!-- Mobile Menu -->
  <div x-show="mobileMenuOpen" x-transition class="md:hidden absolute top-full left-0 w-full bg-white p-6">
    <ul class="flex flex-col gap-4 font-semibold text-black">
      <template x-for="item in navItems" :key="item.name">
        <li x-data="{ open: false }">
          <template x-if="item.dropdown">
            <div>
              <button @click="open = !open" class="flex justify-between w-full">
                <span x-text="item.label"></span>
                <svg class="w-4 h-4 transform transition-transform duration-300"
                     :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                  <path d="M6 9l6 6 6-6" />
                </svg>
              </button>
              <div x-show="open" x-transition class="pl-4 mt-2 flex flex-col gap-2">
                <template x-for="sub in item.dropdown">
                  <a :href="sub.href"
                     :class="sub.active ? 'text-blue-700 font-semibold' : ''"
                     class="hover:text-blue-700">
                    <span x-text="sub.label"></span>
                  </a>
                </template>
              </div>
            </div>
          </template>
          <template x-if="!item.dropdown">
            <a :href="item.href" :class="item.active ? 'text-blue-700 font-bold' : ''">
              <span x-text="item.label"></span>
            </a>
          </template>
        </li>
      </template>
    </ul>
  </div>
</nav>

<script>
  document.addEventListener('alpine:init', () => {
    Alpine.data('navComponent', () => ({
      mobileMenuOpen: false,
      navItems: [
        {
          name: 'landingpage',
          label: 'Home',
          href: '{{ route('front.index') }}',
          active: {{ request()->routeIs('landingpage') ? 'true' : 'false' }}
        },
        {
          name: 'products',
              label: 'Product',
              href: '{{ route('list_product') }}',
              active: {{ request()->routeIs('list_product') ? 'true' : 'false' }}
          // dropdown: [
          //   {
          //     label: 'Products',
          //     href: '{{ route('products') }}',
          //     active: {{ request()->routeIs('products') ? 'true' : 'false' }}
          //   },
          //   {
          //     label: 'List Product',
          //     href: '{{ route('list_product') }}',
          //     active: {{ request()->routeIs('list_product') ? 'true' : 'false' }}
          //   }
          // ]
        },
        {
          name: 'gallery',
          label: 'Gallery',
          href: '{{ route('gallery') }}',
          active: {{ request()->routeIs('gallery') ? 'true' : 'false' }}
        },
        {
          name: 'blog',
          label: 'Blog',
          href: '{{ route('list_blog') }}',
          active: {{ request()->routeIs('list_blog') ? 'true' : 'false' }}
          // dropdown: [
          //   {
          //     label: 'Blog',
          //     href: '{{ route('blog') }}',
          //     active: {{ request()->routeIs('blog') ? 'true' : 'false' }}
          //   },
          //   {
          //     label: 'List Blog',
          //     href: '{{ route('list_blog') }}',
          //     active: {{ request()->routeIs('list_blog') ? 'true' : 'false' }}
          //   }
          // ]
        },
        {
          name: 'aboutus',
          label: 'About Us',
          href: '{{ route('aboutus') }}',
          active: {{ request()->routeIs('aboutus') ? 'true' : 'false' }}
        }
      ],
      init() {
        // No dark mode functionality used anymore
      }
    }));
  });
</script>
