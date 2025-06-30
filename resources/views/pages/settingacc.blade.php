@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 bg-light p-0">
            <div class="sidebar">
                <div class="p-4">
                    <h4 class="text-success mb-4">General</h4>
                    <div class="nav flex-column">
                        <a href="#" class="nav-link d-flex align-items-center mb-3 p-3 bg-white rounded shadow-sm">
                            <i class="fas fa-image me-3 text-muted"></i>
                            <span>Manajemen Akun</span>
                        </a>
                        <a href="#" class="nav-link d-flex align-items-center p-3 bg-success text-white rounded shadow-sm">
                            <i class="fas fa-image me-3"></i>
                            <span>Ganti Password</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="p-4">
                <h2 class="mb-2">Informasi Pribadi Akun</h2>
                <p class="text-muted mb-4">Informasi dan aktivitas properti Anda secara real-time</p>

                <form id="accountForm" action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Section -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="position-relative">
                            <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : 'https://via.placeholder.com/100x100/6c757d/ffffff?text=Profile' }}" 
                                 alt="Profile" 
                                 class="rounded-circle me-3" 
                                 width="100" 
                                 height="100"
                                 id="profilePreview">
                            <input type="file" 
                                   name="profile_image" 
                                   id="profileInput" 
                                   class="d-none" 
                                   accept="image/*"
                                   onchange="previewImage(this)">
                            <button type="button" 
                                    class="btn btn-sm btn-outline-secondary position-absolute bottom-0 end-0 rounded-circle"
                                    onclick="document.getElementById('profileInput').click()">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h5>
                            <p class="text-muted mb-0">{{ auth()->user()->username }}</p>
                            <p class="text-muted mb-0">{{ auth()->user()->phone }}</p>
                        </div>
                    </div>

                    <!-- Full Name Section -->
                    <div class="mb-4">
                        <h6 class="mb-3">Full Name</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First name</label>
                                <input type="text" 
                                       class="form-control bg-light @error('first_name') is-invalid @enderror" 
                                       id="first_name" 
                                       name="first_name" 
                                       value="{{ old('first_name', auth()->user()->first_name) }}"
                                       placeholder="First"
                                       onchange="detectChanges()">
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last name</label>
                                <input type="text" 
                                       class="form-control bg-light @error('last_name') is-invalid @enderror" 
                                       id="last_name" 
                                       name="last_name" 
                                       value="{{ old('last_name', auth()->user()->last_name) }}"
                                       placeholder="Last"
                                       onchange="detectChanges()">
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Username Section -->
                    <div class="mb-4">
                        <h6 class="mb-1">Username</h6>
                        <p class="text-muted small mb-3">Kelola tampilan nama pengguna anda</p>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" 
                                       class="form-control bg-light @error('username') is-invalid @enderror" 
                                       id="username" 
                                       name="username" 
                                       value="{{ old('username', auth()->user()->username) }}"
                                       placeholder="Username"
                                       onchange="detectChanges()">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Phone Number Section -->
                    <div class="mb-4">
                        <h6 class="mb-1">Nomer Handphone</h6>
                        <p class="text-muted small mb-3">kelola kontak nomer handphone akun anda</p>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Nomer Handphone</label>
                                <input type="text" 
                                       class="form-control bg-light @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', auth()->user()->phone) }}"
                                       placeholder="+62 0821-7064-0976"
                                       onchange="detectChanges()">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Update Button -->
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" 
                                    id="updateBtn" 
                                    class="btn btn-primary w-100 py-3" 
                                    disabled>
                                Perbarui
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.sidebar {
    min-height: 100vh;
    background-color: #f8f9fa;
}

.nav-link {
    color: #6c757d;
    text-decoration: none;
    border: none;
    font-weight: 500;
}

.nav-link:hover {
    background-color: #e9ecef !important;
    color: #495057;
}

.bg-success {
    background-color: #28a745 !important;
}

.form-control {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 12px 16px;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    border-radius: 8px;
    font-weight: 500;
}

.btn-primary:disabled {
    background-color: #6c757d;
    border-color: #6c757d;
    opacity: 0.65;
}

.rounded-circle {
    object-fit: cover;
}

h6 {
    font-weight: 600;
    color: #495057;
}

.text-muted {
    color: #6c757d !important;
}
</style>

<script>
// Store original values for comparison
const originalValues = {
    first_name: '{{ auth()->user()->first_name }}',
    last_name: '{{ auth()->user()->last_name }}',
    username: '{{ auth()->user()->username }}',
    phone: '{{ auth()->user()->phone }}'
};

function detectChanges() {
    const currentValues = {
        first_name: document.getElementById('first_name').value,
        last_name: document.getElementById('last_name').value,
        username: document.getElementById('username').value,
        phone: document.getElementById('phone').value
    };

    // Check if any value has changed
    const hasChanges = Object.keys(originalValues).some(key => 
        originalValues[key] !== currentValues[key]
    );

    // Enable/disable update button based on changes
    document.getElementById('updateBtn').disabled = !hasChanges;
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
        
        // Enable update button when image is changed
        document.getElementById('updateBtn').disabled = false;
    }
}

// Add event listeners to all form inputs
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['first_name', 'last_name', 'username', 'phone'];
    inputs.forEach(inputId => {
        document.getElementById(inputId).addEventListener('input', detectChanges);
    });
    
    // Also listen for profile image changes
    document.getElementById('profileInput').addEventListener('change', function() {
        detectChanges();
    });
});
</script>
@endsection