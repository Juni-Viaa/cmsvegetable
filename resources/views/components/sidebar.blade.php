<aside class="w-full lg:w-1/5 bg-[#ffffff] shadow-lg p-0 mb-6 lg:mb-0 min-h-screen">
    <ul class="divide-y divide-white">
        <li>
            <a href="{{ route('settings') }}"
                class="block w-full px-6 py-4 hover:bg-gray-200 active:bg-gray-300 transition">
                <div class="flex items-center space-x-3">
                    <!-- Ikon Manajemen Akun -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11V4m0 0L8 7m4-3l4 3" />
                    </svg>
                    <span class="font-semibold text-lg">Manajemen Akun</span>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('passwordchg') }}"
                class="block w-full px-6 py-4 hover:bg-gray-200 active:bg-gray-300 transition">
                <div class="flex items-center space-x-3">
                    <!-- Ikon Ganti Password -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 11V4m0 0l-4 3m4-3l4 3m-4 3v4a4 4 0 11-8 0v-4m0 0l-4 3m4-3l4 3" />
                    </svg>
                    <span class="font-semibold text-lg">Ganti Password</span>
                </div>
            </a>
        </li>
    </ul>
</aside>
