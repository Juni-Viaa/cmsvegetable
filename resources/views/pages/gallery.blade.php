@extends('layouts.gallery')

@section('title', 'Gallery')

@section('content')

<div class="relative h-64 flex items-center justify-center bg-fixed bg-center bg-cover" style="background-image: url('{{ asset('images/parallax banner.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative z-10 text-center px-4">
        <h1 class="text-white text-5xl font-extrabold drop-shadow-lg" data-aos="fade-down">Our Vegetables</h1>
        <p class="text-gray-200 mt-4 max-w-xl mx-auto font-medium" data-aos="fade-up" data-aos-delay="150">
            Explore our wide selection of fresh, high-quality vegetables sourced directly from trusted local farms.
        </p>
    </div>
</div>

{{-- Menggunakan x-data="galleryPage()" untuk seluruh scope Alpine.js, termasuk modal --}}
<div x-data="galleryPage()" class="max-w-7xl mx-auto px-4 mt-8 font-poppins">

    {{-- Category Filter Section --}}
    <div x-data="{ open: true }" class="w-full mb-10 bg-gradient-to-br from-green-100 to-green-50 p-6 rounded-2xl shadow-md">
        <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
            <h2 class="text-2xl font-bold text-black flex items-center gap-2 ml-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-black fill-current" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                </svg>
                Category Filter
            </h2>
        </div>

        <form method="GET" action="{{ url('/gallery') }}" id="filterForm" x-show="open" x-transition class="mt-4">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-green-200 hover:shadow-md transition-all duration-300 w-full lg:w-1/3">
                    <h3 class="text-black font-semibold mb-4">Sort By</h3>
                    <div class="flex flex-col gap-3">
                        <label class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl px-4 py-3 cursor-pointer">
                            <input type="radio" name="sort" value="latest" {{ request('sort') == 'latest' ? 'checked' : '' }}
                                   class="accent-green-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                            <span class="text-sm font-medium text-gray-700">Latest Update</span>
                        </label>
                        <label class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl px-4 py-3 cursor-pointer">
                            <input type="radio" name="sort" value="az" {{ request('sort') == 'az' ? 'checked' : '' }}
                                   class="accent-green-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                            <span class="text-sm font-medium text-gray-700">Sort A–Z</span>
                        </label>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-2xl shadow-sm border border-green-200 hover:shadow-md transition w-full lg:w-2/3">
                    <h3 class="text-black font-semibold mb-4 flex items-center gap-2">Filter by Category</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($categories as $cat)
                            <label class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl px-4 py-3 cursor-pointer">
                                <input type="checkbox" name="category[]" value="{{ $cat }}"
                                       {{ is_array(request('category')) && in_array($cat, request('category')) ? 'checked' : '' }}
                                       class="accent-green-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                                <span class="text-sm font-medium text-gray-700">{{ ucfirst($cat) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Toggle View --}}
    <div class="flex justify-end mb-6">
        <button id="toggleView" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-full shadow-md flex items-center gap-2 transition">
            <span id="toggleIcon"></span>
            <span id="toggleText"></span>
        </button>
    </div>

    {{-- Gallery Items --}}
    <div id="blogContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-6 transition-all duration-300">
        @foreach ($vegetables as $index => $item)
            <div class="blog-card cursor-pointer bg-white rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-[1.03] hover:shadow-xl product-card animate-fade-up border border-transparent hover:border-green-500 hover:ring hover:ring-green-200"
                 @click="openModal({{ $index }})"> {{-- Menggunakan Alpine.js untuk membuka modal --}}
                <img src="{{ $item->image_url }}" loading="lazy" alt="{{ $item->title }}"
                     class="w-full h-40 object-cover rounded-t-xl transition hover:brightness-110">
                <div class="p-4 product-info">
                    <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mb-2">
                        {{ $item->category->category_name ?? 'Uncategorized' }}
                    </span>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $item->title }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $item->description }}</p>
                </div>
            </div>
        @endforeach

        @if ($vegetables->isEmpty())
            <p class="col-span-full text-center text-gray-500">No gallery items found with the selected filter.</p>
        @endif
    </div>

    {{-- Modal --}}
    <div x-show="modalOpen" x-transition x-cloak class="fixed inset-0 z-50 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl relative overflow-hidden p-6"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-full opacity-0">
            <button @click="closeModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-lg font-bold">&times;</button>
            <img :src="currentProduct.image" alt="" class="w-full max-h-[260px] object-cover rounded-lg" />
            <h2 class="text-xl font-bold text-gray-900" x-text="currentProduct.name"></h2>
            <p class="text-sm text-gray-600 mb-6" x-text="currentProduct.description"></p>
            <div class="flex justify-between">
                <button @click="previousProduct" class="px-4 py-2 bg-white text-gray-800 hover:bg-green-500 hover:text-white rounded-md transition">← Previous</button>
                <button @click="nextProduct" class="px-4 py-2 bg-white text-gray-800 hover:bg-green-500 hover:text-white rounded-md transition">Next →</button>
            </div>
        </div>
    </div>
</div>

<style>
    .list-view {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .list-view .product-card {
        display: flex;
        padding: 1rem;
        text-align: left;
        align-items: flex-start;
    }
    .list-view .product-card img {
        width: 150px;
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
    #closeModal {
        border: none;
        outline: none;
        background: transparent;
    }
</style>

@once
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endonce

<script>
document.addEventListener('DOMContentLoaded', () => {
    const filterForm = document.getElementById('filterForm');
    const inputs = filterForm.querySelectorAll('input[type="checkbox"], input[type="radio"]');
    inputs.forEach(input => {
        // PERBAIKAN DI SINI: Menggunakan filterForm.submit()
        input.addEventListener('change', () => filterForm.submit());
    });

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

    toggleBtn.addEventListener('click', () => {
        isList = !isList;
        container.classList.toggle('list-view');
        container.classList.toggle('grid');
        container.classList.toggle('md:grid-cols-2');
        container.classList.toggle('lg:grid-cols-3');
        updateToggleUI();
    });

    // Manual DOM event listeners for modal (will work alongside Alpine.js)
    const modal = document.getElementById('modalOverlay');
    const closeModal = document.getElementById('closeModal');

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

// Alpine.js data for modal navigation
function galleryPage() {
    return {
        modalOpen: false,
        currentIndex: 0,
        // Ensure this data matches the structure of your $vegetables array
        // Make sure $veg->id is actually the ID for your Gallery model
        products: {!! json_encode($vegetables->map(function($veg) {
            return [
                'id' => $veg->id, // Assuming 'id' exists on your Gallery model
                'name' => $veg->title,
                'image' => $veg->image_url,
                'description' => $veg->description ?? 'No description available'
            ];
        })) !!},
        get currentProduct() {
            return this.products[this.currentIndex];
        },
        openModal(index) {
            this.currentIndex = index;
            this.modalOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.modalOpen = false;
            document.body.style.overflow = '';
        },
        previousProduct() {
            if (this.currentIndex > 0) {
                this.currentIndex--;
            }
        },
        nextProduct() {
            if (this.currentIndex < this.products.length - 1) {
                this.currentIndex++;
            }
        }
    }
}
</script>

@endsection
