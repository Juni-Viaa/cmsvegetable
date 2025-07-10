<!DOCTYPE html>
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
</head>
<body>
    <h2>WhatsApp OTP Verification</h2>
    
    <!-- Form Input Nomor Telepon -->
    <div id="phone-form">
        <form id="send-otp-form">
            <div class="form-group">
                <label for="phone_number">Nomor WhatsApp (dengan +62):</label>
                <input type="text" id="phone_number" name="phone_number" 
                       placeholder="+628123456789" required>
            </div>
            <button type="submit" id="send-otp-btn">Kirim OTP</button>
        </form>
    </div>

    <!-- Form Verifikasi OTP -->
    <div id="otp-form" class="hidden">
        <form id="verify-otp-form">
            <div class="form-group">
                <label for="otp_code">Masukkan Kode OTP:</label>
                <input type="text" id="otp_code" name="otp_code" 
                       placeholder="123456" maxlength="6" required>
            </div>
            <input type="hidden" id="phone_number_hidden" name="phone_number">
            <button type="submit" id="verify-otp-btn">Verifikasi OTP</button>
        </form>
        <button onclick="showPhoneForm()" style="background-color: #6c757d; margin-top: 10px;">
            Kirim Ulang OTP
        </button>
    </div>

    <div id="message-container"></div>

    <script>
        // Setup CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Form elements
        const phoneForm = document.getElementById('phone-form');
        const otpForm = document.getElementById('otp-form');
        const sendOtpForm = document.getElementById('send-otp-form');
        const verifyOtpForm = document.getElementById('verify-otp-form');
        const messageContainer = document.getElementById('message-container');

        // Send OTP
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

        // Verify OTP
        verifyOtpForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const phoneNumber = document.getElementById('phone_number_hidden').value;
            const otpCode = document.getElementById('otp_code').value;
            const verifyBtn = document.getElementById('verify-otp-btn');
            
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
                    // Redirect atau lakukan aksi selanjutnya
                    setTimeout(() => {
                        alert('Verifikasi berhasil! Anda akan diarahkan ke halaman selanjutnya.');
                        // window.location.href = '/dashboard'; // Uncomment untuk redirect
                    }, 2000);
                } else {
                    showMessage(result.message, 'error');
                }
            } catch (error) {
                showMessage('Terjadi kesalahan. Silakan coba lagi.', 'error');
            } finally {
                verifyBtn.disabled = false;
                verifyBtn.textContent = 'Verifikasi OTP';
            }
        });

        function showOtpForm(phoneNumber) {
            phoneForm.classList.add('hidden');
            otpForm.classList.remove('hidden');
            document.getElementById('phone_number_hidden').value = phoneNumber;
            document.getElementById('otp_code').focus();
        }

        function showPhoneForm() {
            otpForm.classList.add('hidden');
            phoneForm.classList.remove('hidden');
            document.getElementById('phone_number').focus();
            document.getElementById('otp_code').value = '';
        }

        function showMessage(message, type) {
            messageContainer.innerHTML = `<div class="message ${type}">${message}</div>`;
            setTimeout(() => {
                messageContainer.innerHTML = '';
            }, 5000);
        }
    </script>
</body>
</html>
