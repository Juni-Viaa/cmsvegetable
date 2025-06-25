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

        {{-- BAGIAN BAWAH: Company + Komentar + Artikel Terkait --}}
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
                                <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center text-white font-bold">G</div>
                                <div class="flex-1">
                                    <div class="flex justify-between text-sm">
                                        <p class="font-semibold">Guest</p>
                                        <p class="text-gray-500">{{ $comment->created_at->format('H:i d/m/Y') }}</p>
                                    </div>
                                    <p class="mt-1 text-gray-700">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada komentar.</p>
                        @endforelse
                    </div>

                    {{-- FORM KOMENTAR --}}
                    <form method="POST" action="{{ url('/products/' . $product->product_id . '/comment') }}" class="mt-6">
                        @csrf
                        <textarea name="content" class="w-full p-2 border rounded" placeholder="Tulis komentar anda..." required></textarea>
                        <button type="submit" class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Kirim Komentar</button>
                    </form>

                </div>
            </div>

            {{-- ARTIKEL TERKAIT --}}
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-700">Artikel Terkait</h2>

                @forelse($related as $item)
                <div class="flex gap-4 bg-white shadow-md rounded-lg p-3">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="w-20 h-20 object-cover rounded-md">
                    <div>
                        <h3 class="font-bold text-sm">{{ $item->name }}</h3>
                        <p class="text-xs text-gray-600">{{ Str::limit($item->description, 50) }}</p>
                    </div>
                </div>
                @empty
                    <p class="text-sm text-gray-500">Tidak ada artikel terkait.</p>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection
