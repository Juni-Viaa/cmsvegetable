{{-- <!DOCTYPE html>
<html>
<head>
    <title>WhatsApp OTP Verification</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #25D366;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #22C55E;
        }
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .hidden {
            display: none;
        }
    </style>
</head> --}}

@extends('layouts.register2')

@section('title', 'Verification')

@push('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
{{--
    OTP Verification (Step 2)
    - User enters phone number, receives OTP
    - User enters OTP in 6-box input
    - On success, user is created in DB and phone is marked as verified
--}}
<div class="p-8 rounded-lg w-full max-w-md text-center">
    <!-- Logo + Text -->
    <div class="flex items-center justify-center mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Sayur Kita Logo" class="w-12 h-12 mr-2">
        <span class="text-xl font-bold text-gray-800">Sayur Kita</span>
    </div>
    
    <h2 class="text-xl font-bold mb-1">Verification Your Account</h2>
    <p class="mb-6 text-gray-700">Please enter your phone number</p>
    <!-- Phone Number Input Form -->
    <div id="phone-form">
        <form id="send-otp-form">
            <div class="form-group">
                <input type="text" id="phone_number" name="phone_number" 
                class="w-full px-4 py-2 border border-gray-300 rounded-md mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror" placeholder="+628123456789" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700" id="send-otp-btn">Kirim OTP</button>
        </form>
    </div>

    <!-- OTP Input Form (6 boxes) -->
    <div id="otp-form" class="hidden">
        <form id="verify-otp-form">
            <div class="form-group mb-4">
                <label for="otp_code" class="block text-sm font-medium text-gray-700 mb-3">Masukkan Kode OTP:</label>
                <div x-data="otpInput()" x-ref="otpRoot" class="flex justify-center gap-2 sm:gap-3">
                    <template x-for="(digit, index) in 6" :key="index">
                        <input 
                            type="text"
                            x-ref="`otp${index}`"
                            x-model="otpDigits[index]"
                            @input="handleInput($event, index)"
                            @keydown="handleKeydown($event, index)"
                            @paste="handlePaste($event)"
                            @focus="handleFocus(index)"
                            class="w-12 h-12 sm:w-14 sm:h-14 text-center text-lg font-semibold border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            :class="{
                                'border-red-500 focus:ring-red-500 focus:border-red-500': hasError,
                                'border-green-500 focus:ring-green-500 focus:border-green-500': isComplete && !hasError
                            }"
                            maxlength="1"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            autocomplete="one-time-code"
                            :autofocus="index === 0"
                        >
                    </template>
                    <input type="hidden" id="otp_code" name="otp_code" x-model="combinedOtp">
                </div>
                <!-- Error message for OTP -->
                <div x-show="hasError" x-transition 
                    class="text-white text-sm mt-2 bg-red-500/90 border border-red-700 rounded-lg px-3 py-2 shadow-sm flex items-center justify-center gap-2 animate-shake"
                    style="display: none; min-height:2.5rem;">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0Z"/></svg>
                    <span>Kode OTP tidak valid. Silakan coba lagi.</span>
                </div>
            </div>
            <input type="hidden" id="phone_number_hidden" name="phone_number">
            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded hover:bg-blue-700" id="verify-otp-btn">Verifikasi OTP</button>
        </form>
        <button onclick="showPhoneForm()" class="w-full bg-gray-600 text-white font-semibold py-2 rounded hover:bg-gray-700 mt-3">
            Kirim Ulang OTP
        </button>
    </div>

    <!-- Message container for success/error feedback -->
    <div id="message-container"></div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
/**
 * Alpine.js component for OTP input (6 boxes)
 * Handles auto-advance, paste, backspace, and error state
 */
window.otpInput = function() {
    return {
        otpDigits: Array(6).fill(''),
        hasError: false,
        isComplete: false,
        get combinedOtp() { return this.otpDigits.join(''); },
        handleInput(e, idx) {
            let val = e.target.value.replace(/\D/g, '');
            // Always keep only the first digit in the box
            if (val.length > 1) {
                // Distribute digits if more than one entered
                for (let i = 0; i < val.length && idx + i < 6; i++) {
                    this.otpDigits[idx + i] = val[i];
                    if (this.$refs['otp'+(idx+i)]) this.$refs['otp'+(idx+i)].value = val[i];
                }
                let next = idx + val.length < 6 ? idx + val.length : 5;
                if (this.$refs['otp'+next]) this.$refs['otp'+next].focus();
            } else {
                this.otpDigits[idx] = val;
                e.target.value = val;
                // Move to next box if a digit is entered
                if (val.length === 1 && idx < 5 && this.$refs['otp'+(idx+1)]) {
                    this.$refs['otp'+(idx+1)].focus();
                }
            }
            // Force only one digit in the input
            if (e.target.value.length > 1) e.target.value = e.target.value[0];
            this.isComplete = this.otpDigits.every(d => d !== '');
            this.hasError = false;
        },
        handleKeydown(e, idx) {
            if (e.key === 'Backspace') {
                if (!e.target.value && idx > 0 && this.$refs['otp'+(idx-1)]) {
                    this.$refs['otp'+(idx-1)].focus();
                    this.otpDigits[idx-1] = '';
                } else if (e.target.value) {
                    this.otpDigits[idx] = '';
                    e.target.value = '';
                }
            }
            if (e.key === 'ArrowLeft' && idx > 0 && this.$refs['otp'+(idx-1)]) this.$refs['otp'+(idx-1)].focus();
            if (e.key === 'ArrowRight' && idx < 5 && this.$refs['otp'+(idx+1)]) this.$refs['otp'+(idx+1)].focus();
        },
        handlePaste(e) {
            e.preventDefault();
            const numbers = e.clipboardData.getData('text').replace(/\D/g, '').slice(0,6);
            numbers.split('').forEach((d, i) => {
                this.otpDigits[i] = d;
                if (this.$refs['otp'+i]) this.$refs['otp'+i].value = d;
            });
            const next = numbers.length < 6 ? numbers.length : 5;
            if (this.$refs['otp'+next]) this.$refs['otp'+next].focus();
            this.isComplete = this.otpDigits.every(d => d !== '');
        },
        handleFocus(idx) {
            if (this.$refs['otp'+idx]) this.$refs['otp'+idx].select();
        },
        setError() { this.hasError = true; },
        reset() {
            this.otpDigits = Array(6).fill('');
            this.hasError = false;
            this.isComplete = false;
            if (this.$refs.otp0) this.$refs.otp0.focus();
        }
    }
}

// --- OTP Verification Page Logic ---
// Setup CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Form elements
const phoneForm = document.getElementById('phone-form');
const otpForm = document.getElementById('otp-form');
const sendOtpForm = document.getElementById('send-otp-form');
const verifyOtpForm = document.getElementById('verify-otp-form');
const messageContainer = document.getElementById('message-container');

// Handle phone number submission and send OTP
sendOtpForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const phoneNumber = document.getElementById('phone_number').value;
    const sendBtn = document.getElementById('send-otp-btn');
    sendBtn.disabled = true;
    sendBtn.textContent = 'Mengirim...';
    try {
        const response = await fetch('/api/otp/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ phone_number: phoneNumber })
        });
        const result = await response.json();
        if (result.success) {
            showMessage(result.message, 'success');
            showOtpForm(phoneNumber);
        } else {
            showMessage(result.message, 'error');
        }
    } catch (error) {
        showMessage('Terjadi kesalahan. Silakan coba lagi.', 'error');
    } finally {
        sendBtn.disabled = false;
        sendBtn.textContent = 'Kirim OTP';
    }
});

// Handle OTP verification
verifyOtpForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const phoneNumber = document.getElementById('phone_number_hidden').value;
    const otpCode = document.getElementById('otp_code').value;
    const verifyBtn = document.getElementById('verify-otp-btn');
    // Get Alpine.js component instance via ref
    const otpComponentRoot = document.querySelector('[x-ref="otpRoot"]');
    const otpComponent = otpComponentRoot && otpComponentRoot.__x ? otpComponentRoot.__x.$data : null;
    verifyBtn.disabled = true;
    verifyBtn.textContent = 'Memverifikasi...';
    try {
        const response = await fetch('/api/otp/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ 
                phone_number: phoneNumber,
                otp_code: otpCode 
            })
        });
        const result = await response.json();
        if (result.success) {
            showMessage(result.message, 'success');
            // Redirect to login after success
            setTimeout(() => {
                window.location.href = '/login';
            }, 1000);
        } else {
            showMessage(result.message, 'error');
            // Show error state on OTP inputs
            if (otpComponent) otpComponent.setError();
        }
    } catch (error) {
        showMessage('Terjadi kesalahan. Silakan coba lagi.', 'error');
        if (otpComponent) otpComponent.setError();
    } finally {
        verifyBtn.disabled = false;
        verifyBtn.textContent = 'Verifikasi OTP';
    }
});

/**
 * Show the OTP input form and hide the phone input form.
 * @param {string} phoneNumber
 */
function showOtpForm(phoneNumber) {
    phoneForm.classList.add('hidden');
    otpForm.classList.remove('hidden');
    document.getElementById('phone_number_hidden').value = phoneNumber;
    // Focus first OTP input after a short delay
    setTimeout(() => {
        const firstOtpInput = document.querySelector('[x-ref="otp0"]');
        if (firstOtpInput) {
            firstOtpInput.focus();
        }
    }, 100);
}

/**
 * Show the phone input form and hide the OTP input form.
 * Resets the OTP component.
 */
function showPhoneForm() {
    otpForm.classList.add('hidden');
    phoneForm.classList.remove('hidden');
    document.getElementById('phone_number').focus();
    // Reset OTP component
    const otpComponentRoot = document.querySelector('[x-ref="otpRoot"]');
    if (otpComponentRoot && otpComponentRoot.__x) {
        otpComponentRoot.__x.$data.reset();
    }
}

/**
 * Display a styled message in the message container.
 * @param {string} message - The message text to display.
 * @param {string} type - 'success' or 'error' for styling.
 */
function showMessage(message, type) {
    // SVG icons for success and error
    const icons = {
        success: `<svg class=\"w-5 h-5 text-green-600\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M5 13l4 4L19 7\"/></svg>`,
        error: `<svg class=\"w-5 h-5 text-red-600\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6 18L18 6M6 6l12 12\"/></svg>`
    };
    // Tailwind classes for each message type
    const classes = {
        success: 'flex items-center gap-2 bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded-lg shadow mt-2 mb-1',
        error:   'flex items-center gap-2 bg-red-100 border border-red-400 text-red-800 px-4 py-2 rounded-lg shadow mt-2 mb-1'
    };
    // Compose the message HTML
    messageContainer.innerHTML = `
        <div class="${classes[type] || classes.error}">
            ${icons[type] || icons.error}
            <span>${message}</span>
        </div>
    `;
    // Automatically clear the message after 5 seconds
    setTimeout(() => {
        messageContainer.innerHTML = '';
    }, 5000);
}
</script>
@endpush
