<div class="w-64 bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-6">General</h2>
    
    <nav class="space-y-2">
        <a href="{{ route('settings.index') }}" 
           class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('settings.index') ? 'bg-secondary text-white' : 'text-gray-600 hover:bg-gray-50' }}">
            <div class="w-6 h-6 border-2 {{ request()->routeIs('settings.index') ? 'border-white' : 'border-gray-400' }} rounded flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <span class="font-medium">Manajemen Akun</span>
        </a>
        
        <a href="{{ route('settings.password') }}" 
           class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('settings.password') ? 'bg-secondary text-white' : 'text-gray-600 hover:bg-gray-50' }}">
            <div class="w-6 h-6 border-2 {{ request()->routeIs('settings.password') ? 'border-white' : 'border-gray-400' }} rounded flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <span class="font-medium">Ganti Password</span>
        </a>
    </nav>
</div>