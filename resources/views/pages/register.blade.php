@extends('layouts.register')

@section('title', 'Register')

@section('content')
{{--
    Registration Form (Step 1)
    - Collects only basic user info (no phone number)
    - On submit, data is validated and stored in session
    - User is redirected to OTP verification for phone number and OTP
--}}
<div class="flex items-center justify-center gap-3 mb-4">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12">
    <h1 class="text-xl font-bold text-gray-800">Sayur Kita</h1>
</div>

<div class="text-center mb-6">
    <h2 class="text-xl font-bold mb-1">Create Your Sayurkita Account</h2>
    <p class="text-sm text-gray-600">Let's set up your account</p>
</div>

<form action="{{ route('register.store') }}" method="POST" class="space-y-4 text-left">
    @csrf
    {{-- First and Last Name --}}
    <div class="flex gap-2">
        <input type="text" name="first_name" placeholder="First Name" class="w-1/2 p-2 border border-gray-300 rounded" required>
        <input type="text" name="last_name" placeholder="Last Name" class="w-1/2 p-2 border border-gray-300 rounded" required>
    </div>
    {{-- Username --}}
    <input type="text" name="username" placeholder="Username" class="w-full p-2 border border-gray-300 rounded" required>
    {{-- Password and Confirmation --}}
    <input type="password" name="password" placeholder="Password" class="w-full p-2 border border-gray-300 rounded" required>
    <input type="password" name="password_confirmation" placeholder="Confirm your password" class="w-full p-2 border border-gray-300 rounded" required>
    {{-- Submit Button --}}
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition duration-200">Continue</button>
</form>

{{-- Display validation errors --}}
@if ($errors->any())
    <div class="mb-4 p-4 bg-red-200 text-red-700 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<p class="mt-4 text-sm text-gray-600 text-center">
    Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log In</a>
</p>
@endsection
