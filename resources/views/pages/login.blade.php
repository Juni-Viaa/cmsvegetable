@extends('layouts.login')

@section('title', 'Login')

@section('content')
<div class="text-center">
    <!-- Logo + Sayur Kita -->
    <div class="flex items-center justify-center mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 mr-2">
        <h1 class="text-xl font-bold text-gray-800">Sayur Kita</h1>
    </div>

    <!-- Judul -->
    <h2 class="text-lg font-bold mb-2">Log In</h2>
    <p class="text-sm text-gray-700 mb-4">Log In with Your Sayurkita Account </p>

    <!-- Tampilkan error -->
    @if ($errors->any())
        <div class="mb-2 text-red-600 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('auth.login') }}" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Phone, Username" class="w-full px-4 py-2 border border-gray-300 rounded-md mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <input type="password" name="password" placeholder="Password" class="w-full px-4 py-2 border border-gray-300 rounded-md mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <a href="{{ route('lupa_password') }}" class="text-sm text-blue-600 hover:underline block mb-4">Forgot your password?</a>

        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700">Continue</button>

        <p class="text-sm text-gray-800 mt-4">New to SayurKita ? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Create an account</a></p>
    </form>
</div>
@endsection
