@extends('layouts.gallery')

@section('title', 'Gallery')

@section('content')

<!-- Banner -->
<div class="relative h-64 flex items-center justify-center bg-fixed bg-center bg-cover" style="background-image: url('{{ asset('images/parallax banner.jpg') }}');">
    <div class="bg-black bg-opacity-50 w-full h-full absolute inset-0"></div>
    <div class="relative z-10 text-center px-4">
        <h1 class="text-white text-5xl font-extrabold drop-shadow-lg" data-aos="fade-down">Our Vegetables</h1>
        <p class="text-gray-200 mt-4 max-w-xl mx-auto font-medium" data-aos="fade-up" data-aos-delay="150">
            Explore our wide selection of fresh, high-quality vegetables sourced directly from trusted local farms.
        </p>
    </div>
</div>

<!-- Filter + Gallery -->
<div class="max-w-7xl mx-auto px-4 py-12 font-poppins">

    <!-- Filter -->
    <div x-data="{ open: true }" class="w-full mb-10 bg-gradient-to-br from-green-100 to-green-50 p-6 rounded-2xl shadow-md">
        <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="size-6 text-black" viewBox="0 0 24 24">
                    <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                </svg>
                <h2 class="text-xl font-bold text-black">Category Filter</h2>
            </div>
        </div>
        <form method="GET" action="{{ url('/gallery') }}" id="filterForm" x-show="open" x-transition class="mt-4">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-green-200 hover:shadow-md transition-all duration-300">
                <h3 class="text-black font-semibold mb-4 text-base">Category</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach ($categories as $cat)
                        <label class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl px-4 py-3 hover:border-green-400 transition cursor-pointer">
                            <input
                                type="checkbox"
                                name="category[]"
                                value="{{ $cat }}"
                                {{ is_array(request('category')) && in_array($cat, request('category')) ? 'checked' : '' }}
                                class="accent-green-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                            >
                            <span class="text-sm font-medium text-gray-700">{{ ucfirst($cat) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </form>
    </div>

    <!-- Toggle View Button -->
    <div class="flex justify-end mb-6">
        <button id="toggleView" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-full shadow-md flex items-center gap-2 transition-all">
            <span id="toggleIcon"></span>
            <span id="toggleText"></span>
        </button>
    </div>

    <!-- Gallery Container -->
    <div id="blogContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6 transition-all duration-300">
        @foreach ($vegetables as $item)
        <div class="blog-card cursor-pointer bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-[1.03] hover:shadow-xl product-card animate-fade-up border border-transparent hover:border-green-500 hover:ring hover:ring-green-200"
             data-category="{{ strtolower($item->category->category_name ?? 'lainnya') }}"
             data-title="{{ $item->title }}"
             data-image="{{ $item->image_url }}"
             data-desc="{{ $item->description }}">
            <img src="{{ $item->image_url }}" loading="lazy" alt="{{ $item->title }}"
                 class="w-full h-40 object-cover rounded-t-xl transition duration-300 ease-in-out hover:brightness-110">
            <div class="p-4 product-info">
                <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mb-2">
                    {{ $item->category->category_name ?? 'Uncategorized' }}
                </span>
                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $item->title }}</h3>
                <p class="text-sm text-gray-600">{{ $item->description }}</p>
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
        border: 1px solid transparent;
    }

    .list-view .product-card:hover {
        border-color: #22c55e;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.3);
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
        const toggleIcon = document.getElementById('toggleIcon');
        const toggleText = document.getElementById('toggleText');
        const container = document.getElementById('blogContainer');

        const iconGrid = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 6h7v7H3zM14 6h7v7h-7zM3 15h7v7H3zM14 15h7v7h-7z"/></svg>`;
        const iconList = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Z"/></svg>`;

        let isList = container.classList.contains('list-view');

        const updateToggleUI = () => {
            toggleIcon.innerHTML = isList ? iconList : iconGrid;
            toggleText.textContent = isList ? 'List View' : 'Grid View';
        };

        updateToggleUI();

        inputs.forEach(input => {
            input.addEventListener('change', () => form.submit());
        });

        toggleBtn.addEventListener('click', () => {
            isList = !isList;
            if (isList) {
                container.classList.remove('grid', 'md:grid-cols-2');
                container.classList.add('list-view');
            } else {
                container.classList.remove('list-view');
                container.classList.add('grid', 'md:grid-cols-2');
            }
            updateToggleUI();
        });

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
