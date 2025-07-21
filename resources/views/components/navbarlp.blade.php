<script src="https://unpkg.com/alpinejs" defer></script>

<div class="container max-w-[1130px] mx-auto relative pt-10 z-10">
    <nav class="flex flex-wrap items-center justify-between bg-white p-[20px_30px] rounded-[20px] gap-y-3">
        <div class="flex items-center gap-3">
            <div class="flex shrink-0 h-[43px] overflow-hidden">
                <img src="{{ asset('assets/logo/logo.png') }}" class="object-contain w-full h-full" alt="logo">
            </div>
            <div class="flex flex-col">
                <p id="CompanyName" class="font-extrabold text-xl leading-[30px]">SayurKita</p>
                <p id="CompanyTagline" class="text-sm text-cp-light-grey">Vegetable Revolution</p>
            </div>
        </div>
        <ul class="flex flex-wrap items-center gap-[30px]">
            <li
                class="{{ request()->routeIs('front.index') ? 'text-cp-dark-blue' : '' }} font-semibold hover:text-cp-dark-blue transition-all duration-300">
                <a href="{{ route('front.index') }}">Home</a>
            </li>
            <li
                class="{{ request()->routeIs('products') ? 'text-cp-dark-blue' : '' }}font-semibold hover:text-cp-dark-blue transition-all duration-300">
                <a href="{{ route('list_product') }}">Products</a>
            </li>
            <li
                class="{{ request()->routeIs('blog') ? 'text-cp-dark-blue' : '' }} font-semibold hover:text-cp-dark-blue transition-all duration-300">
                <a href="{{ route('list_blog') }}">Blog</a>
            </li>
            <li
                class="{{ request()->routeIs('gallery') ? 'text-cp-dark-blue' : '' }}font-semibold hover:text-cp-dark-blue transition-all duration-300">
                <a href="{{ route('gallery') }}">Gallery</a>
            </li>
            <li
                class="{{ request()->routeIs('aboutus') ? 'text-cp-dark-blue' : '' }} font-semibold hover:text-cp-dark-blue transition-all duration-300">
                <a href="{{ route('aboutus') }}">About</a>
            </li>
        </ul>

        @guest
            <a href="{{ route('login') }}"
                class="bg-cp-dark-blue p-[14px_20px] w-fit rounded-xl hover:shadow-[0_12px_30px_0_#312ECB66] transition-all duration-300 font-bold text-white">
                Login
            </a>
        @endguest

        @auth
            <div x-data="{ open: false }" class="relative">
                <!-- Trigger Button -->
                <button @click="open = !open" class="text-black p-[14px_20px] w-fit rounded-xl flex items-center gap-2">
                    {{ Auth::user()->username }}
                    <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <div x-show="open" x-cloak @click.outside="open = false" x-transition
                    class="absolute p-4 right-0 mt-2 bg-white border rounded-xl shadow-lg z-50 min-w-[160px] space-y-2">
                    <div class=" text-sm text-gray-800 hover:bg-gray-100 rounded-md transition-colors duration-200">
                        <a href="{{ route('settings.index') }}">
                            Pengaturan Akun
                        </a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 rounded-md transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </nav>
</div>
