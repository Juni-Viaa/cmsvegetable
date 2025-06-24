@extends('layouts.products')

@section('title', 'Products')

@section('content') 
<div class="bg-gray-100 py-10 px-4 min-h-screen">
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- DETAIL PRODUK --}}
        <div class="bg-white rounded-xl shadow-md flex flex-col md:flex-row overflow-hidden">
            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="md:w-1/3 w-full object-cover h-64 md:h-auto">
            <div class="p-6 flex-1 space-y-3">
                <h2 class="text-xl font-bold">{{ $product->name }}</h2>
                <div class="flex justify-between text-sm text-gray-600">
                    <span class="bg-gray-200 px-2 py-1 rounded-md">{{ $product->category->category_name ?? 'Kategori' }}</span>
                    <span class="bg-gray-200 px-2 py-1 rounded-md">{{ $product->created_at->format('d/m/Y') }}</span>
                </div>
                <p class="text-gray-700 text-sm">
                    {{ $product->description }}
                </p>
            </div>
        </div>

        {{-- BAGIAN BAWAH --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- COMPANY + KOMENTAR --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md p-6 space-y-6">

                    {{-- COMPANY PROFILE --}}
                    <div>
                        <h3 class="text-lg font-bold mb-2">Company Profile</h3>
                        <p class="text-sm text-gray-800">
                            Sayur Kita is an Indonesian vegetable export company committed to delivering fresh, high-quality produce to international markets. Partnering with local farmers, we provide a wide range of sustainably grown vegetables such as spinach, chili, and long beans. With strict quality control, reliable logistics, and a passion for healthy living, Sayur Kita ensures every shipment meets global standards while empowering rural communities and promoting eco-friendly agriculture.
                        </p>
                    </div>

                    {{-- FLASH MESSAGE --}}
                    @if(session('success'))
                        <div class="p-2 bg-green-200 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- KOMENTAR --}}
                    <div class="space-y-4">
                        @forelse($comments as $comment)
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <div class="flex gap-4 items-start">
                                <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($comment->user->username ?? 'G', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between text-sm">
                                        <p class="font-semibold">{{ $comment->user->username ?? 'Guest' }}</p>
                                        <p class="text-gray-500">{{ $comment->created_at->format('H:i d/m/Y') }}</p>
                                    </div>
                                    <p class="mt-1 text-gray-700">{{ $comment->content }}</p>

                                    {{-- Tombol balas --}}
                                    @auth
                                    <button onclick="document.getElementById('reply-{{ $comment->id }}').classList.toggle('hidden')" class="text-xs text-green-600 mt-2">Balas</button>

                                    {{-- Form Reply --}}
                                    <form method="POST" action="{{ url('/products/' . $product->product_id . '/comment') }}" id="reply-{{ $comment->id }}" class="mt-2 hidden">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <textarea name="content" class="w-full p-2 border rounded" placeholder="Tulis balasan..." required></textarea>
                                        <button type="submit" class="mt-1 px-3 py-1 bg-green-600 text-white rounded text-sm">Kirim Balasan</button>
                                    </form>
                                    @endauth

                                    {{-- Tampilkan balasan --}}
                                    @foreach($comment->replies as $reply)
                                        <div class="mt-4 ml-6 p-3 bg-white border rounded-lg">
                                            <p class="text-sm font-semibold">{{ $reply->user->username ?? 'Guest' }}</p>
                                            <p class="text-xs text-gray-500">{{ $reply->created_at->format('H:i d/m/Y') }}</p>
                                            <p class="text-sm">{{ $reply->content }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada komentar.</p>
                        @endforelse

                        {{-- FORM KOMENTAR --}}
                        <form method="POST" action="{{ url('/products/' . $product->product_id . '/comment') }}" class="mt-6" id="commentForm">
                            @csrf
                            <textarea id="commentContent" name="content" class="w-full p-2 border rounded" placeholder="Tulis komentar anda..." required></textarea>
                            <button type="submit" class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Kirim Komentar</button>
                        </form>
                    </div>

                </div>
            </div>

            {{-- ARTIKEL TERKAIT --}}
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-700">Artikel Terkait</h2>

                @forelse($related as $item)
                <a href="{{ url('/products/' . $item->product_id) }}" class="block">
                    <div class="flex gap-4 bg-white shadow-md rounded-lg p-3 hover:shadow-lg transition">
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="w-20 h-20 object-cover rounded-md">
                        <div>
                            <h3 class="font-bold text-sm">{{ $item->name }}</h3>
                            <p class="text-xs text-gray-600">{{ Str::limit($item->description, 50) }}</p>
                        </div>
                    </div>
                </a>
                @empty
                    <p class="text-sm text-gray-500">Tidak ada artikel terkait.</p>
                @endforelse
            </div>

        </div>
    </div>
</div>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@guest
<script>
document.getElementById('commentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Login Diperlukan',
        text: 'Anda harus login terlebih dahulu untuk mengirim komentar.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Login Sekarang',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ route('login') }}";
        } else {
            // Kosongkan textarea jika batal
            document.getElementById('commentContent').value = '';
        }
    });
});
</script>
@endguest

@endsection
