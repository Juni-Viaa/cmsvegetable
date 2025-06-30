@extends('layouts.register3')

@section('title', 'Register3')

@section('content')
<div class="text-center">
    <!-- Logo + Sayur Kita -->
    <div class="flex items-center justify-center mb-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 mr-2">
        <h1 class="text-xl font-bold text-gray-800">Sayur Kita</h1>
    </div>

    <!-- Nomor -->
    <p class="text-sm text-gray-700 mb-4">
        {{ session('register_phone') ?? 'Nomor tidak ditemukan' }}
    </p>

    <!-- Judul -->
    <h2 class="text-lg font-bold text-gray-900 mb-1">Verify Your Phone Number</h2>
    <p class="text-sm text-gray-700 mb-6">Enter the verification code we sent to your phone number</p>

    <!-- Kotak OTP -->
    <form action="{{ route('register3.verify') }}" method="POST" class="space-y-4" onsubmit="combineOtp(event)">
        @csrf
        <div class="flex justify-center gap-3 mb-4">
            @for ($i = 1; $i <= 4; $i++)
                <input type="text" maxlength="1" class="otp-input w-12 h-12 border border-gray-300 text-center text-xl rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            @endfor
        </div>

        <input type="hidden" name="otp" id="otp_hidden">

        <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700 transition duration-200">Continue</button>
    </form>
</div>

<script>
function combineOtp(e) {
    e.preventDefault();
    const digits = document.querySelectorAll('.otp-input');
    const otp = Array.from(digits).map(i => i.value).join('');
    document.getElementById('otp_hidden').value = otp;
    e.target.submit();
}
</script>
@endsection
