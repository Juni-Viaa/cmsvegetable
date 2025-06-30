@extends('settings.layouts.app')

@section('title', 'Informasi Pribadi Akun')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Informasi Pribadi Akun</h1>
        <p class="text-gray-600">Informasi dan aktivitas properti Anda secara real-time</p>
    </div>
    
    <!-- User Profile -->
    <x-user-profile :user="$user" />
    
    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    <!-- Profile Form -->
    <form action="{{ route('settings.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Full Name Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Full Name</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First name</label>
                    <input type="text" 
                           name="first_name" 
                           value="{{ old('first_name', $user->first_name ?? 'First') }}"
                           placeholder="First"
                           class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('first_name') border-red-500 @enderror">
                    @error('first_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last name</label>
                    <input type="text" 
                           name="last_name" 
                           value="{{ old('last_name', $user->last_name ?? 'Last') }}"
                           placeholder="Last"
                           class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('last_name') border-red-500 @enderror">
                    @error('last_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Username Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Username</h3>
            <p class="text-gray-600 mb-4">Kelola tampilan nama pengguna anda</p>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" 
                       name="username" 
                       value="{{ old('username', $user->username ?? 'Username') }}"
                       placeholder="Username"
                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('username') border-red-500 @enderror">
                @error('username')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Phone Number Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Nomer Handphone</h3>
            <p class="text-gray-600 mb-4">kelola kontak nomer handphone akun anda</p>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomer Handphone</label>
                <input type="tel" 
                       name="phone" 
                       value="{{ old('phone', $user->phone ?? '+62 0821-7064-0976') }}"
                       placeholder="+62 0821-7064-0976"
                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Submit Button -->
        <div class="flex justify-center">
            <button type="submit" 
                    class="px-8 py-3 bg-primary text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors">
                Perbarui
            </button>
        </div>
    </form>
</div>
@endsection