@extends('layouts.content')

@section('title', 'Blog')

@section('content')
    <style>
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.4s ease-out both;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 3px;
        }
    </style>

    <div class="bg-gray-100 py-10 px-4 min-h-screen">
        <div class="max-w-6xl mx-auto space-y-6">

            {{-- === BANNER === --}}
            <div class="relative h-64 rounded-xl overflow-hidden shadow-xl bg-black group">
                <img src="{{ asset('storage/' . $blog->image_path) }}"
                     alt="{{ $blog->title }}"
                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-in-out transform group-hover:scale-105 group-hover:brightness-75">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                <div class="absolute bottom-5 left-6 z-20">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white drop-shadow-lg select-none">
                        {{ $blog->title }}
                    </h1>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                {{-- === KONTEN UTAMA === --}}
                <div class="lg:col-span-2 bg-white shadow-xl rounded-xl p-6 fade-in-up">
                    <div class="flex justify-between items-center text-sm text-gray-500 mb-4 select-none">
                        <span class="font-medium">{{ $blog->title }}</span>
                        <span>{{ $blog->created_at->format('H:i d/m/Y') }}</span>
                    </div>
                    <p class="text-gray-700 leading-relaxed select-text">
                        {!! $blog->content !!}
                    </p>

                    {{-- FLASH MESSAGE --}}
                    @if (session('success'))
                        <div class="p-2 bg-green-200 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- KOMENTAR --}}
                    @forelse($comments as $comment)
                        <div class="bg-gray-100 p-4 rounded-lg" x-data="{ showReply: false, replyContent: '' }">
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

                                    {{-- BALASAN --}}
                                    <div x-data="{ showReply: false, replyContent: '' }">
                                        <button @click="showReply = !showReply"
                                                class="text-xs text-blue-600 mt-2">Balas</button>
                                        <form x-show="showReply" x-cloak x-data x-ref="replyForm" method="POST"
                                              action="{{ url('/blogs/' . $blog->blog_id . '/replies') }}"
                                              @submit.prevent="$refs.replyParentId.value = '{{ $comment->comment_id }}'; $el.submit();"
                                              class="mt-2">
                                            @csrf
                                            <input type="hidden" name="parent_id" x-ref="replyParentId">
                                            <textarea x-model="replyContent" name="content" rows="2"
                                                      class="w-full p-2 border rounded mt-1"
                                                      placeholder="Tulis balasan..."></textarea>
                                            <div class="flex justify-end mt-2 space-x-2">
                                                <button type="button" @click="showReply = false; replyContent = ''"
                                                        class="text-xs text-gray-500">Batal</button>
                                                <button type="submit"
                                                        class="bg-blue-600 text-white text-sm px-3 py-1 rounded">Kirim</button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- TAMPILKAN BALASAN --}}
                                    @if ($comment->replies && $comment->replies->count())
                                        <div class="mt-3 space-y-2 border-l border-gray-100">
                                            @foreach ($comment->replies as $reply)
                                                <div class="flex pl-4 bg-gray-50 gap-4 items-start rounded-lg">
                                                    <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center text-white font-bold">
                                                        {{ strtoupper(substr($comment->user->username ?? 'G', 0, 1)) }}
                                                    </div>
                                                    <div class="flex-1 bg-gray-50 p-3 rounded">
                                                        <div class="flex justify-between text-sm">
                                                            <p class="font-semibold">{{ $reply->user->username ?? 'Guest' }}</p>
                                                            <p class="text-gray-500">{{ $reply->created_at->format('H:i d/m/Y') }}</p>
                                                        </div>
                                                        <p class="mt-1 text-gray-700">{{ $reply->content }}</p>
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
                          action="{{ url('/blogs/' . $blog->blog_id . '/comment') }}" class="mt-6"
                          x-data="{ showLoginModal: false, isLoggedIn: {{ auth()->check() ? 'true' : 'false' }} }"
                          @submit.prevent="isLoggedIn ? $nextTick(() => $el.submit()) : (showLoginModal = true)">
                        @csrf
                        <textarea id="commentContent" name="content" class="w-full p-2 border rounded" placeholder="Tulis komentar anda..." required></textarea>
                        <button type="submit" class="mt-2 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
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
                                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</button>
                                    <a href="{{ route('login') }}"
                                       class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                        Login Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- === SIDEBAR ARTIKEL TERKAIT === --}}
                <div class="space-y-4 fade-in-up">
                    <h2 class="text-xl font-semibold text-gray-700 select-none">Artikel Terkait</h2>
                    @foreach ($related as $index => $item)
                        <a href="{{ url('/blogs/' . $item->blog_id) }}"
                           x-data="{ show: false }"
                           x-init="setTimeout(() => show = true, {{ 200 * $index }})"
                           x-show="show"
                           x-transition:enter="transition ease-out duration-500"
                           x-transition:enter-start="opacity-0 translate-y-4"
                           x-transition:enter-end="opacity-100 translate-y-0"
                           class="block group overflow-hidden backdrop-blur-sm bg-white/40 border border-white/30 rounded-xl shadow-md p-3 transform transition duration-300 hover:scale-105 hover:shadow-xl hover:border-indigo-400/50"
                           aria-label="Artikel terkait: {{ $item->title }}">
                            <div class="flex gap-4 items-center relative z-20">
                                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" loading="lazy"
                                     class="w-20 h-20 object-cover rounded-md border border-white/30 transform transition duration-300 group-hover:scale-105" />
                                <div>
                                    <h3 class="font-bold text-sm text-gray-900 group-hover:text-green-700">{{ $item->title }}</h3>
                                    <p class="text-xs text-gray-700 mt-1">{{ \Str::limit(strip_tags($item->content), 50) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
