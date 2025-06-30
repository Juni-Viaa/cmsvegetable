@extends('settings.settings.layouts.app')

@section('title', 'Ubah Informasi Password')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Ubah Informasi Password</h1>
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
    
    <!-- Password Form -->
    <form action="{{ route('settings.password.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Password Section -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Password</h3>
            <p class="text-gray-600 mb-6">Ubah kata sandi anda saat ini</p>
            
            <!-- Current Password -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kata sandi lama</label>
                <input type="password" 
                       name="current_password" 
                       placeholder="Password lama"
                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('current_password') border-red-500 @enderror">
                @error('current_password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- New Password -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kata sandi lama</label>
                <input type="password" 
                       name="password" 
                       placeholder="Password baru"
                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Confirm Password -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kata sandi lama</label>
                <input type="password" 
                       name="password_confirmation" 
                       placeholder="Konfirmasi password baru"
                       class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
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