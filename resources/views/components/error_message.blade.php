{{-- Success/Error Messages --}}
@if(session('success'))
    <div class="mb-2 p-4 text-green-700 bg-green-100 rounded-lg">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-2 p-4 text-red-700 bg-red-100 rounded-lg">
        {{ session('error') }}
    </div>
@endif