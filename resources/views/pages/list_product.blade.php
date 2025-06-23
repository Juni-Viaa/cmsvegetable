@extends('layouts.list_product')

@section('title', 'List Product')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 font-poppins">
    <!-- Filter Accordion -->
    <div x-data="{ open: true }" class="w-full mb-10 bg-gradient-to-tr from-green-200 via-green-50 to-green-100 p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
            <h2 class="text-2xl font-bold text-green-800">🎯 Filter Produk</h2>
            <span x-text="open ? '▲' : '▼'" class="text-green-800 text-xl font-bold"></span>
        </div>

        <form method="GET" action="{{ url('/list_product') }}" id="filterForm"
              x-show="open" x-transition
              class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-sm text-gray-800">
            <!-- Sort Options -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-green-200 hover:shadow-md transition-all duration-300">
                <h3 class="text-green-700 font-semibold mb-2">Urutkan Berdasarkan</h3>
                <div class="flex flex-col gap-1">
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="sort" value="terbaru" {{ request('sort') == 'terbaru' ? 'checked' : '' }} class="accent-green-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <span>Update Terbaru</span>
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="radio" name="sort" value="az" {{ request('sort') == 'az' ? 'checked' : '' }} class="accent-green-600 focus:ring-2 focus:ring-green-400 focus:outline-none">
                        <span>Urutan A-Z</span>
                    </label>
                </div>
            </div>

            <!-- Category Filters -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-green-200 hover:shadow-md transition-all duration-300">
                <h3 class="text-green-700 font-semibold mb-2">Kategori</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach ($categories as $cat)
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="category[]" value="{{ $cat->category_id }}"
                                {{ is_array(request('categories')) && in_array($cat->category_id, request('categories')) ? 'checked' : '' }} class="accent-green-600 focus:ring-2 focus:ring-green-400 focus:outline-none"
                            >
                            <span>{{ $cat->category_name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </form>
    </div>

    <!-- Toggle View Button -->
    <div class="flex justify-end mb-4">
        <button id="toggleView" class="px-4 py-2 text-sm font-medium bg-green-600 text-white rounded-full shadow-md hover:bg-green-700 transition">
            📃 List View
        </button>
    </div>

    <!-- Product Grid/List -->
    <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pb-6 transition-all duration-300">
        @forelse ($vegetables as $veg)
            <div class="bg-white p-4 rounded-2xl shadow-md hover:shadow-xl hover:ring-2 hover:ring-green-200 transform transition duration-300 hover:scale-[1.03] product-card animate-fade-up">
                <img src="{{ asset('storage/' . $veg->image_path) }}" alt="{{ $veg->name }}" class="w-full h-40 object-contain bg-gray-100 p-2 rounded mb-4">
                <div class="product-info text-center">
                    <h2 class="text-base font-semibold text-gray-800">{{ $veg->name }}</h2>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">Tidak ada produk ditemukan dengan filter tersebut.</p>
        @endforelse
    </div>

    <!-- ✅ Pagination -->
    <div class="mt-8">
        {{ $vegetables->links() }}
    </div>
</div>

<!-- Custom CSS -->
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
</style>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('filterForm');
        const inputs = form.querySelectorAll('input[type="checkbox"], input[type="radio"]');
        const toggleBtn = document.getElementById('toggleView');
        const grid = document.getElementById('productGrid');
        let isList = false;

        inputs.forEach(input => {
            input.addEventListener('change', () => {
                form.submit();
            });
        });

        toggleBtn.addEventListener('click', () => {
            isList = !isList;

            if (isList) {
                grid.classList.remove('grid', 'sm:grid-cols-2', 'md:grid-cols-3', 'lg:grid-cols-4');
                grid.classList.add('list-view');
                toggleBtn.textContent = '🧱 Grid View';
            } else {
                grid.classList.remove('list-view');
                grid.classList.add('grid', 'sm:grid-cols-2', 'md:grid-cols-3', 'lg:grid-cols-4');
                toggleBtn.textContent = '📃 List View';
            }
        });
    });
</script>
@endsection
