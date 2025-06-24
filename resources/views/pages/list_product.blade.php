@extends('layouts.list_product')

@section('title', 'List Product')

@section('content')
<div x-data="productModal()" class="max-w-7xl mx-auto px-4 py-12 font-poppins">
    
    {{-- ============================ FILTER SECTION ============================ --}}
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
            <span x-text="open ? '' : ''" class="text-black text-xl font-bold"></span>
        </div>

        {{-- Form Filter dengan GET method --}}
        <form method="GET" action="{{ url('/list_product') }}" id="filterForm"
            x-show="open" x-transition
            class="mt-6 flex flex-col lg:flex-row gap-6 text-sm text-gray-800">
            
            {{-- Sort --}}
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-green-200 hover:shadow-md transition-all duration-300 w-full lg:w-1/3">
                <h3 class="text-black font-semibold mb-4">Sort By</h3>
                <div class="flex flex-col gap-3">
                    <label class="inline-flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl px-4 py-2 cursor-pointer hover:border-green-400">
                        <input type="radio" name="sort" value="terbaru" {{ request('sort') == 'terbaru' ? 'checked' : '' }} class="accent-green-600">
                        <span class="text-sm font-medium text-gray-700">Latest Update</span>
                    </label>
                    <label class="inline-flex items-center gap-3 bg-green-50 border border-green-200 rounded-xl px-4 py-2 cursor-pointer hover:border-green-400">
                        <input type="radio" name="sort" value="az" {{ request('sort') == 'az' ? 'checked' : '' }} class="accent-green-600">
                        <span class="text-sm font-medium text-gray-700">Sort A–Z</span>
                    </label>
                </div>
            </div>

            {{-- Filter kategori --}}
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-green-200 hover:shadow-md transition-all duration-300 w-full lg:w-2/3">
                <h3 class="text-black font-semibold mb-4 flex items-center gap-2">
                    <span></span> Filter by Category
                </h3>
                <div class="flex flex-wrap gap-3">
                    @php $snackCategory = $categories->firstWhere('category_name', 'Snacks'); @endphp

                    @foreach ($categories as $cat)
                        @if ($cat->category_name === 'Beverages')
                            <div class="flex flex-row gap-3">
                                <label class="w-40 flex items-center gap-2 bg-green-50 border border-green-200 rounded-xl px-4 py-2 cursor-pointer hover:border-green-400 text-sm">
                                    <input type="checkbox" name="category[]" value="{{ $cat->category_id }}" {{ is_array(request('category')) && in_array($cat->category_id, request('category')) ? 'checked' : '' }} class="accent-green-600">
                                    <span class="text-gray-700 font-medium">{{ $cat->category_name }}</span>
                                </label>
                                @if ($snackCategory)
                                    <label class="w-40 flex items-center gap-2 bg-green-50 border border-green-200 rounded-xl px-4 py-2 cursor-pointer hover:border-green-400 text-sm">
                                        <input type="checkbox" name="category[]" value="{{ $snackCategory->category_id }}" {{ is_array(request('category')) && in_array($snackCategory->category_id, request('category')) ? 'checked' : '' }} class="accent-green-600">
                                        <span class="text-gray-700 font-medium">{{ $snackCategory->category_name }}</span>
                                    </label>
                                @endif
                            </div>
                        @elseif ($cat->category_name !== 'Snacks')
                            <label class="w-40 flex items-center gap-2 bg-green-50 border border-green-200 rounded-xl px-4 py-2 cursor-pointer hover:border-green-400 text-sm">
                                <input type="checkbox" name="category[]" value="{{ $cat->category_id }}" {{ is_array(request('category')) && in_array($cat->category_id, request('category')) ? 'checked' : '' }} class="accent-green-600">
                                <span class="text-gray-700 font-medium">{{ $cat->category_name }}</span>
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>
        </form>
    </div>

    {{-- ============================ TOGGLE VIEW ============================ --}}
    <div class="flex justify-end mb-6">
        <button id="toggleView" class="flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-full shadow-lg transition-all duration-300">
            <span id="viewIcon" class="text-white"></span>
            <span id="viewText"></span>
        </button>
    </div>

    {{-- ============================ PRODUK ============================ --}}
    <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-6 transition-all duration-300">
        @foreach ($vegetables as $index => $veg)
        <div class="product-card bg-white rounded-2xl shadow-md hover:shadow-xl hover:ring-2 hover:ring-green-200 transform transition duration-300 hover:scale-[1.03] animate-fade-up">
            <img src="{{ asset('storage/' . $veg->image_path) }}" alt="{{ $veg->product_name }}"
                @click="openModal({{ $index }})"
                class="w-full h-48 object-cover rounded-t-2xl cursor-pointer" />
            <div class="p-4 flex flex-col justify-between flex-grow text-center sm:text-left">
                <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mb-2 self-center sm:self-start">
                    {{ $veg->category->category_name ?? 'Tanpa Kategori' }}
                </span>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $veg->product_name }}</h3>
            </div>
        </div>
        @endforeach

        @if ($vegetables->isEmpty())
            <p class="col-span-full text-center text-gray-500">No products found with the selected filter.</p>
        @endif
    </div>

    {{-- ============================ PAGINATION ============================ --}}
    <div class="mt-8">
        {{ $vegetables->links() }}
    </div>

    {{-- ============================ MODAL ============================ --}}
    <div x-show="modalOpen" x-transition x-cloak class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl relative overflow-hidden p-6"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="translate-y-full opacity-0">
            <button @click="closeModal" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 text-lg font-bold">&times;</button>
            <a :href="`/products/${currentProduct.id}`">
            <img :src="currentProduct.image" alt="" class="w-full h-64 object-contain mb-4 border rounded-md bg-gray-50" />
            </a>
            <h2 class="text-xl font-bold text-gray-900" x-text="currentProduct.name"></h2>
            <p class="text-sm text-gray-600 mb-6" x-text="currentProduct.description"></p>
            <div class="flex justify-between">
                <button @click="previousProduct" class="px-4 py-2 bg-white text-gray-800 hover:bg-green-500 hover:text-white rounded-md transition">← Previous</button>
                <button @click="nextProduct" class="px-4 py-2 bg-white text-gray-800 hover:bg-green-500 hover:text-white rounded-md transition">Next →</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('toggleView');
    const grid = document.getElementById('productGrid');
    const viewText = document.getElementById('viewText');
    const viewIcon = document.getElementById('viewIcon');
    let isList = false;

    const iconGrid = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 6h7v7H3zM14 6h7v7h-7zM3 15h7v7H3zM14 15h7v7h-7z"/></svg>`;
    const iconList = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Z"/></svg>`;

    viewText.textContent = 'Grid View';
    viewIcon.innerHTML = iconGrid;

    toggleBtn.addEventListener('click', () => {
        isList = !isList;
        if (isList) {
            grid.classList.remove('grid', 'sm:grid-cols-2', 'lg:grid-cols-3');
            grid.classList.add('list-view');
            viewText.textContent = 'List View';
            viewIcon.innerHTML = iconList;
        } else {
            grid.classList.remove('list-view');
            grid.classList.add('grid', 'sm:grid-cols-2', 'lg:grid-cols-3');
            viewText.textContent = 'Grid View';
            viewIcon.innerHTML = iconGrid;
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const filterForm = document.getElementById('filterForm');
    const inputs = filterForm.querySelectorAll('input[type="checkbox"], input[type="radio"]');
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            filterForm.submit();
        });
    });
});
</script>

<script>
function productModal() {
    return {
        modalOpen: false,
        currentIndex: 0,
        products: {!! json_encode($vegetables->map(function($v) {
            return [
                'id' => $v->product_id,
                'name' => $v->product_name,
                'image' => asset('storage/' . $v->image_path),
                'description' => $v->description ?? 'Tidak ada deskripsi'
            ];
        })) !!},
        get currentProduct() {
            return this.products[this.currentIndex];
        },
        openModal(index) {
            this.currentIndex = index;
            this.modalOpen = true;
        },
        closeModal() {
            this.modalOpen = false;
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
</style>
@endsection
