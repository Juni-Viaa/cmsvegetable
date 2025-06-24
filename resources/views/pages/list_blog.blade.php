@extends('layouts.list_blog')

@section('title', 'List Blog')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 font-poppins">
    <!-- Filter Accordion (mengikuti style dan behavior seperti list_product) -->
    <div x-data="{ open: true }" class="w-full mb-10 bg-gradient-to-tr from-green-200 via-green-50 to-green-100 p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
            <h2 class="text-2xl font-bold text-green-800">🔍 Filter Kategori</h2>
            <span x-text="open ? '▲' : '▼'" class="text-green-800 text-xl font-bold"></span>
        </div>

        <form id="filterForm" x-show="open" x-transition class="mt-6 flex flex-wrap gap-4 text-sm text-gray-700">
            @foreach ($categories as $cat)
                <label class="inline-flex items-center gap-2 bg-white p-3 rounded-xl shadow-sm border border-green-200 hover:shadow-md transition-all duration-300 cursor-pointer">
                    <input
                        type="checkbox"
                        name="category[]"
                        value="{{ strtolower($cat) }}"
                        {{ is_array(request('category')) && in_array(strtolower($cat), request('category')) ? 'checked' : '' }}
                        class="category-filter accent-green-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                    >
                    <span>{{ $cat }}</span>
                </label>
            @endforeach
        </form>
    </div>

    <!-- Toggle View Button -->
    <div class="flex justify-end mb-4">
        <button id="toggleView" class="px-4 py-2 text-sm font-medium bg-green-600 text-white rounded-full shadow-md hover:bg-green-700 transition">
            📃 List View
        </button>
    </div>

    <!-- Blog Grid/List -->
    <div id="blogContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-6 transition-all duration-300">
        @foreach ($blogs as $item)
        <div class="blog-card cursor-pointer bg-white rounded-2xl shadow-md hover:shadow-xl hover:ring-2 hover:ring-green-200 transform transition duration-300 hover:scale-[1.03] product-card animate-fade-up"
             data-category="{{ strtolower($item->category->category_name ?? 'lainnya') }}"
             data-title="{{ $item->title }}"
             data-image="{{ asset('storage/' . $item->image_path) }}"
             data-desc="{{ $item->content }}">
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
    </div>
</div>

<!-- Modal -->
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative animate-fade-in">
        <button id="closeModal" class="absolute top-3 right-4 text-gray-500 hover:bg-gray-200 hover:text-gray-700 text-xl font-bold rounded-full px-2 py-1 transition">&times;</button>
        <img id="modalImage" src="" alt="" class="w-full h-48 object-cover rounded-lg mb-4">
        <h3 id="modalTitle" class="text-xl font-bold text-gray-900 mb-2"></h3>
        <p id="modalDesc" class="text-gray-700 text-sm leading-relaxed max-h-48 overflow-y-auto"></p>

        <div class="flex justify-between mt-6">
            <button id="prevBtn" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">&larr; Sebelumnya</button>
            <button id="nextBtn" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">Selanjutnya &rarr;</button>
        </div>
    </div>
</div>

<!-- Styles -->
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
        transition: all 0.3s ease;
    }

    .list-view .product-card img {
        width: 120px;
        height: auto;
        margin-right: 1.5rem;
        border-radius: 1rem;
    }

    .list-view .product-info {
        flex-grow: 1;
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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('filterForm');
        const inputs = form.querySelectorAll('input[type="checkbox"]');
        const toggleBtn = document.getElementById('toggleView');
        const container = document.getElementById('blogContainer');
        let isList = false;

        // Submit form on filter change
        inputs.forEach(input => {
            input.addEventListener('change', () => {
                form.submit();
            });
        });

        // Toggle Grid/List view button
        toggleBtn.addEventListener('click', () => {
            isList = !isList;

            if (isList) {
                container.classList.remove('grid', 'sm:grid-cols-2', 'lg:grid-cols-3');
                container.classList.add('list-view');
                toggleBtn.textContent = '🧱 Grid View';
            } else {
                container.classList.remove('list-view');
                container.classList.add('grid', 'sm:grid-cols-2', 'lg:grid-cols-3');
                toggleBtn.textContent = '📃 List View';
            }
        });

        // Modal handling (optional, sama seperti versi sebelumnya)
        const blogCards = document.querySelectorAll('.blog-card');
        const modal = document.getElementById('modalOverlay');
        const modalImg = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const closeModal = document.getElementById('closeModal');

        blogCards.forEach(card => {
            card.addEventListener('click', () => {
                modalImg.src = card.dataset.image;
                modalTitle.textContent = card.dataset.title;
                modalDesc.textContent = card.dataset.desc;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                closeModal.focus();
            });
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        });
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    });
</script>
@endsection
