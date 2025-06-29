@extends('layouts.register2')

@section('title', 'Register2')

@section('content')
<div class="p-8 rounded-lg w-full max-w-md text-center">
    <!-- Logo + Text -->
    <div class="flex items-center justify-center mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Sayur Kita Logo" class="w-12 h-12 mr-2">
        <span class="text-xl font-bold text-gray-800">Sayur Kita</span>
    </div>

    <h2 class="text-xl font-bold mb-1">Create Your Sayurkita Account</h2>
    <p class="mb-6 text-gray-700">Please enter your phone number</p>

    {{-- Notifikasi Berhasil --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi Gagal --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validasi Error --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-left">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register2.store') }}" method="POST">
        @csrf
        <input
            type="text"
            name="phone"
            placeholder="Phone Number"
            value="{{ old('phone') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-md mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror"
        >
        
        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700">
            Continue
        </button>
    </form>
</div>
@endsection
