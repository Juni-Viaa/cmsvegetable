@extends('layouts.list_blog')

@section('title', 'List Blog')

@section('content')
{{-- Memindahkan x-data="blogPage()" ke div pembungkus utama --}}
<div x-data="blogPage()" class="max-w-7xl mx-auto px-4 py-12 font-poppins">

    {{-- Product Filter --}}
    <div x-data="{ open: true }" class="w-full mb-10 bg-gradient-to-tr from-green-200 via-green-50 to-green-100 p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
            <h2 class="text-2xl font-bold text-black flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                    class="size-6 text-black fill-current">
                    <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                </svg>
                Product Filter
            </h2>
        </div>

        {{-- Form filter --}}
        <form method="GET" action="{{ url('/list_blog') }}" id="filterForm" x-show="open" x-transition class="mt-6 flex flex-col lg:flex-row gap-6 text-sm text-gray-700">

            {{-- Sort By --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border border-green-200 w-full lg:w-1/3">
                <h3 class="text-black font-semibold mb-4">Sort By</h3>
                <label class="flex items-center space-x-2 mb-2 bg-green-50 px-4 py-2 rounded-xl">
                    <input type="radio" name="sort" value="latest" {{ request('sort') == 'latest' ? 'checked' : '' }} class="accent-green-600">
                    <span class="text-sm font-medium text-gray-700">Latest Update</span>
                </label>
                <label class="flex items-center space-x-2 bg-green-50 px-4 py-2 rounded-xl">
                    <input type="radio" name="sort" value="az" {{ request('sort') == 'az' ? 'checked' : '' }} class="accent-green-600">
                    <span class="text-sm font-medium text-gray-700">Sort A–Z</span>
                </label>
            </div>

            {{-- Filter by Category --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border border-green-200 w-full lg:w-2/3">
                <h3 class="text-black font-semibold mb-3 text-sm">Filter by Category</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($categories as $cat)
                        <label class="inline-flex items-center gap-2 bg-green-50 px-4 py-2 rounded-xl border border-green-100 hover:shadow transition">
                            <input
                                type="checkbox"
                                name="category[]"
                                value="{{ $cat }}"
                                {{ is_array(request('category')) && in_array($cat, request('category')) ? 'checked' : '' }}
                                class="accent-green-600"
                            >
                            <span class="text-sm font-medium text-gray-700">{{ $cat }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

        </form>
    </div>

    {{-- Toggle List/Grid --}}
    <div class="flex justify-end mb-4">
        <button id="toggleView" class="px-4 py-2 text-sm font-medium bg-green-600 text-white rounded-full shadow-md hover:bg-green-700 transition flex items-center gap-2">
            <span id="viewIcon" class="text-white"></span>
            <span id="viewText"></span>
        </button>
    </div>

    {{-- Blog Container --}}
    <div id="blogContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-6 transition-all duration-300">
        @foreach ($blogs as $index => $item) {{-- Pastikan $index ada --}}
        <div class="blog-card cursor-pointer bg-white rounded-2xl shadow-md hover:shadow-xl hover:ring-2 hover:ring-green-200 transform transition duration-300 hover:scale-[1.03] product-card animate-fade-up"
             @click="openModal({{ $index }})"> {{-- Panggil openModal Alpine.js --}}
            <img src="{{ asset('storage/' . $item->image_path) }}" loading="lazy" alt="{{ $item->title }}" class="w-full h-48 object-cover rounded-t-2xl">
            <div class="p-4 flex flex-col justify-between flex-grow text-center sm:text-left">
                <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mb-2 self-center sm:self-start">
                    {{ $item->category->category_name ?? 'Tanpa Kategori' }}
                </span>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $item->title }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ \Str::limit(strip_tags($item->content), 100) }}</p>
            </div>
        </div>
        @endforeach

        @if ($blogs->isEmpty())
            <p class="col-span-full text-center text-gray-500">No blogs found with the selected filter.</p>
        @endif
    </div>

    {{-- ============================ PAGINATION ============================ --}}
    <div class="mt-8">
        {{ $blogs->links() }}
    </div>

    {{-- Modal Preview --}}
    <div x-show="modalOpen" x-transition x-cloak class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative animate-fade-in"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-full opacity-0">
            <button @click="closeModal" class="absolute top-3 right-4 text-gray-500  hover:text-red-700 text-xl font-bold rounded-full px-2 py-1 transition">&times;</button>
            {{-- Menggunakan binding Alpine.js untuk modal content --}}
            <img :src="currentBlog.image" alt="" class="w-full h-48 object-cover rounded-lg mb-4">
            <h3 class="text-xl font-bold text-gray-900 mb-2" x-text="currentBlog.title"></h3>
            <p class="text-gray-700 text-sm leading-relaxed max-h-48 overflow-y-auto" x-text="currentBlog.description"></p>
            <div class="flex justify-between mt-6">
                {{-- Memanggil fungsi yang benar di Alpine.js --}}
                <button @click="previousProduct" class="px-4 py-2 bg-white text-gray-800 hover:bg-green-500 hover:text-white rounded-md transition">← Previous</button>
                <button @click="nextProduct" class="px-4 py-2 bg-white text-gray-800 hover:bg-green-500 hover:text-white rounded-md transition">Next →</button>
            </div>
        </div>
    </div>
</div>

{{-- CSS --}}
<style>
    .list-view {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .list-view .product-card {
        display: flex;
        align-items: center;
        padding: 1rem;
        text-align: left;
    }
    .list-view .product-card img {
        width: 120px;
        height: auto;
        margin-right: 1.5rem;
        border-radius: 1rem;
    }
    .animate-fade-up {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.5s ease-in-out forwards;
    }
    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes fade-in {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-fade-in {
        animation: fade-in 0.25s ease-out;
    }
</style>

{{-- JS --}}
@once
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endonce

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterForm = document.getElementById('filterForm');
        const inputs = filterForm.querySelectorAll('input'); // includes checkbox and radio

        // Auto submit saat input berubah
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                filterForm.submit(); // Menggunakan filterForm yang sudah dideklarasikan
            });
        });

        const toggleBtn = document.getElementById('toggleView');
        const container = document.getElementById('blogContainer');
        const viewText = document.getElementById('viewText');
        const viewIcon = document.getElementById('viewIcon');
        let isList = false; // Default view is Grid

        // Icons from product list (SVG strings)
        const iconGrid = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 6h7v7H3zM14 6h7v7h-7zM3 15h7v7H3zM14 15h7v7h-7z"/></svg>`;
        const iconList = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Z"/></svg>`;

        // Set initial view button state
        viewText.textContent = 'Grid View'; // Initial state text for toggle
        viewIcon.innerHTML = iconGrid; // Initial state icon for toggle

        toggleBtn.addEventListener('click', () => {
            isList = !isList;
            if (isList) {
                container.classList.remove('grid', 'sm:grid-cols-2', 'lg:grid-cols-3');
                container.classList.add('list-view');
                viewText.textContent = 'List View';
                viewIcon.innerHTML = iconList;
            } else {
                container.classList.remove('list-view');
                container.classList.add('grid', 'sm:grid-cols-2', 'lg:grid-cols-3');
                viewText.textContent = 'Grid View';
                viewIcon.innerHTML = iconGrid;
            }
        });

        // Hapus semua event listener DOM manual untuk modal di sini,
        // karena Alpine.js akan menanganinya
        // blogCards.forEach(...)
        // closeModal.addEventListener(...)
        // modal.addEventListener(...)
        // document.addEventListener('keydown', ...)
    });

    // Alpine.js data for blog modal navigation
    function blogPage() {
        return {
            modalOpen: false,
            currentIndex: 0,
            blogs: {!! json_encode($blogs->map(function($b) {
                return [
                    'id' => $b->id, // Pastikan 'id' ada di model Blog
                    'title' => $b->title,
                    'image' => asset('storage/' . $b->image_path),
                    'description' => strip_tags($b->content) // strip_tags untuk deskripsi modal
                ];
            })) !!},
            get currentBlog() {
                return this.blogs[this.currentIndex];
            },
            openModal(index) {
                this.currentIndex = index;
                this.modalOpen = true;
                document.body.style.overflow = 'hidden';
                // Alpine.js akan otomatis memperbarui konten modal
            },
            closeModal() {
                this.modalOpen = false;
                document.body.style.overflow = '';
            },
            previousBlog() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                }
            },
            nextBlog() {
                if (this.currentIndex < this.blogs.length - 1) {
                    this.currentIndex++;
                }
            }
        }
    }
</script>
@endsection
