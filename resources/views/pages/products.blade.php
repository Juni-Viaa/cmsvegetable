@extends('layouts.products')

@section('title', 'Products')

@section('content')
    <div class="bg-gray-100 py-10 px-4 min-h-screen">
        <div class="max-w-6xl mx-auto space-y-8">
            {{-- DETAIL PRODUK --}}
            <div class="bg-white rounded-xl shadow-md flex flex-col md:flex-row overflow-hidden">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->product_name }}"
                    class="md:w-1/3 w-full object-cover h-64 md:h-auto transition-transform duration-300 hover:scale-105 shadow-md">

                <div class="p-6 flex-1 space-y-3">
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-md font-medium">
                            {{ $product->category->category_name ?? 'Kategori' }}
                        </span>
                        <span>{{ $product->created_at->format('d M Y') }}</span>
                    </div>

                    <h2 class="text-2xl font-semibold text-gray-800 leading-snug">
                        {{ $product->product_name }}
                    </h2>

                    <p class="text-sm text-gray-700 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>
            </div>

            {{-- BAGIAN BAWAH --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- COMPANY PROFILE & KOMENTAR --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-md p-6 space-y-6">
                        {{-- COMPANY PROFILE --}}
                        <div>
                            <h3 class="text-lg font-bold mb-2">Company Profile</h3>
                            <p class="text-sm text-gray-800">
                                Sayur Kita is an Indonesian vegetable export company committed to delivering fresh,
                                high-quality produce to international markets...
                            </p>
                        </div>

                        {{-- FLASH MESSAGE --}}
                        @if (session('success'))
                            <div class="p-2 bg-green-200 text-green-800 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- KOMENTAR --}}
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

                                        {{-- Balasan --}}
                                        <div x-data="{ showReply: false, replyContent: '' }">
                                            <button @click="showReply = !showReply"
                                                class="text-xs text-blue-600 mt-2">Balas</button>

                                            <form x-show="showReply" x-cloak method="POST"
                                                action="{{ url('/products/' . $product->product_id . '/replies') }}"
                                                @submit.prevent=" $refs.replyParentId.value = '{{ $comment->comment_id }}'; $el.submit();"
                                                x-ref="replyForm" class="mt-2 space-y-2">
                                                @csrf
                                                <input type="hidden" name="parent_id" x-ref="replyParentId">
                                                <textarea x-model="replyContent" name="content" rows="2"
                                                    class="w-full p-2 border rounded mt-1"
                                                    placeholder="Tulis balasan..."></textarea>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="showReply = false; replyContent = ''"
                                                        class="text-xs text-gray-500">Batal</button>
                                                    <button type="submit"
                                                        class="bg-blue-600 text-white text-sm px-3 py-1 rounded">Kirim</button>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- Tampilkan Balasan --}}
                                        @if ($comment->replies && $comment->replies->count())
                                            <div class="mt-3 space-y-2 border-l border-gray-200 pl-4">
                                                @foreach ($comment->replies as $reply)
                                                    <div class="flex gap-3 items-start bg-gray-50 p-3 rounded-lg">
                                                        <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center text-white font-bold">
                                                            {{ strtoupper(substr($reply->user->username ?? 'G', 0, 1)) }}
                                                        </div>
                                                        <div class="flex-1">
                                                            <div class="flex justify-between text-sm">
                                                                <p class="font-semibold">
                                                                    {{ $reply->user->username ?? 'Guest' }}
                                                                </p>
                                                                <p class="text-gray-500">
                                                                    {{ $reply->created_at->format('H:i d/m/Y') }}
                                                                </p>
                                                            </div>
                                                            <p class="text-gray-700 mt-1">{{ $reply->content }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada komentar.</p>
                        @endforelse

                        {{-- FORM KOMENTAR --}}
                        <form id="commentForm" method="POST"
                            action="{{ url('/products/' . $product->product_id . '/comment') }}"
                            x-data="{ showLoginModal: false, isLoggedIn: {{ auth()->check() ? 'true' : 'false' }} }"
                            @submit.prevent="isLoggedIn ? $nextTick(() => $el.submit()) : (showLoginModal = true)"
                            class="mt-6 space-y-3">
                            @csrf
                            <textarea id="commentContent" name="content" rows="3"
                                class="w-full p-3 border rounded text-sm"
                                placeholder="Tulis komentar anda..." required></textarea>
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Kirim Komentar
                            </button>

                            {{-- MODAL LOGIN --}}
                            <div x-show="showLoginModal"
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
                                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                    <h2 class="text-lg font-semibold mb-4">Login Diperlukan</h2>
                                    <p class="text-sm text-gray-700 mb-6">
                                        Anda harus login terlebih dahulu untuk mengirim komentar.
                                    </p>
                                    <div class="flex justify-end gap-3">
                                        <button type="button"
                                            @click="document.getElementById('commentContent').value = ''; showLoginModal = false"
                                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                                            Batal
                                        </button>
                                        <a href="{{ route('login') }}"
                                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                            Login Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ARTIKEL TERKAIT --}}
                <div class="space-y-4 fade-in-up">
    <h2 class="text-xl font-semibold text-gray-700 select-none">Artikel Terkait</h2>
    @foreach ($related as $index => $item)
        <a href="{{ url('/products/' . $item->product_id) }}"
           x-data="{ show: false }"
           x-init="setTimeout(() => show = true, {{ 200 * $index }})"
           x-show="show"
           x-transition:enter="transition ease-out duration-500"
           x-transition:enter-start="opacity-0 translate-y-4"
           x-transition:enter-end="opacity-100 translate-y-0"
           class="block group overflow-hidden backdrop-blur-sm bg-white/40 border border-white/30 rounded-xl shadow-md p-3 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:border-indigo-400/50"
           aria-label="Produk terkait: {{ $item->product_name }}">
            <div class="flex gap-4 items-center relative z-20">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->product_name }}" loading="lazy"
                     class="w-20 h-20 object-cover rounded-md border border-white/30 transform transition duration-300 group-hover:scale-105" />
                <div>
                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-green-700">{{ $item->product_name }}</h3>
                    <p class="text-xs text-gray-700 mt-1">{{ \Str::limit(strip_tags($item->description), 50) }}</p>
                </div>
            </div>
        </a>
    @endforeach
</div>
            </div>
        </div>
    </div>
@endsection
