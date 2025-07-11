@extends('layouts.list_blog')

@section('title', 'List Blog')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12 font-poppins">

    {{-- Blog Filter --}}
    <div x-data="{ open: true }"
        class="w-full mb-10 bg-gradient-to-tr from-green-200 via-green-50 to-green-100 p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
            <h2 class="text-2xl font-bold text-black flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 text-black fill-current">
                    <path d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12Z"/>
                </svg>
                Blog Filter
            </h2>
        </div>

        {{-- Filter Form --}}
        <form method="GET" action="{{ url('/list_blog') }}" id="filterForm" x-show="open" x-transition class="mt-6 flex flex-col lg:flex-row gap-6 text-sm text-gray-700">

            {{-- Sort --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border border-green-200 w-full lg:w-1/3">
                <h3 class="text-black font-semibold mb-4">Sort By</h3>
                <label class="flex items-center space-x-2 mb-2 bg-green-50 px-4 py-2 rounded-xl border border-green-200 hover:border-green-400 cursor-pointer transition">
                    <input type="radio" name="sort" value="terbaru" {{ request('sort') == 'terbaru' ? 'checked' : '' }} class="accent-green-600">
                    <span class="text-sm font-medium text-gray-700">Latest Update</span>
                </label>
                <label class="flex items-center space-x-2 mb-2 bg-green-50 px-4 py-2 rounded-xl border border-green-200 hover:border-green-400 cursor-pointer transition">
                    <input type="radio" name="sort" value="az" {{ request('sort') == 'az' ? 'checked' : '' }} class="accent-green-600">
                    <span class="text-sm font-medium text-gray-700">Sort A–Z</span>
                </label>
            </div>

            {{-- Filter by Category --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border border-green-200 w-full lg:w-2/3">
                <h3 class="text-black font-semibold mb-3 text-sm">Filter by Category</h3>
                <div class="flex flex-wrap gap-2">
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

    {{-- Toggle View --}}
    <div class="flex justify-end mb-4">
        <button id="toggleView" class="px-4 py-2 text-sm font-medium bg-green-600 text-white rounded-full shadow-md hover:bg-green-700 transition flex items-center gap-2">
            <span id="viewIcon" class="text-white"></span>
            <span id="viewText"></span>
        </button>
    </div>

    {{-- Blog List --}}
    <div id="blogGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-6 transition-all duration-300">
        @foreach ($blogs as $blog)
            <a href="{{ url('/blogs/' . $blog->blog_id) }}"
               class="blog-card block bg-white rounded-2xl shadow-md hover:shadow-xl hover:ring-2 hover:ring-green-200 transform transition duration-300 hover:scale-[1.03] animate-fade-up">
                <img src="{{ asset('storage/' . $blog->image_path) }}" alt="{{ $blog->title }}"
                     class="w-full h-48 object-cover rounded-t-2xl cursor-pointer" />
                <div class="p-4 flex flex-col justify-between flex-grow text-center sm:text-left">
                    <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full mb-2 self-center sm:self-start">
                        {{ $blog->category->category_name ?? 'Tanpa Kategori' }}
                    </span>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $blog->title }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ \Str::limit(strip_tags($blog->content), 100) }}</p>
                </div>
            </a>
        @endforeach

        @if ($blogs->isEmpty())
            <p class="col-span-full text-center text-gray-500">No blogs found with the selected filter.</p>
        @endif
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $blogs->links() }}
    </div>
</div>

{{-- JS View Toggle + Filter --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // === TOGGLE VIEW: Grid ↔ List ===
        const toggleBtn = document.getElementById('toggleView');
        const grid = document.getElementById('blogGrid');
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

        // === FILTER FORM LOGIC (Radio Toggle + Checkbox Submit) ===
        const filterForm = document.getElementById('filterForm');

        // --- RADIO: Toggle on label click ---
        const radioInputs = filterForm.querySelectorAll('input[type="radio"]');
        radioInputs.forEach(radio => {
            const label = radio.closest('label');
            if (!label) return;

            label.addEventListener('mousedown', () => {
                radio.wasChecked = radio.checked;
            });

            label.addEventListener('click', (e) => {
                e.preventDefault(); // prevent native behavior
                if (radio.wasChecked) {
                    radio.checked = false;
                    const url = new URL(window.location.href);
                    url.searchParams.delete(radio.name);
                    window.location.href = url.toString();
                } else {
                    radio.checked = true;
                    filterForm.submit();
                }
            });
        });

        // --- CHECKBOX: Submit on change ---
        const checkboxInputs = filterForm.querySelectorAll('input[type="checkbox"]');
        checkboxInputs.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                filterForm.submit();
            });
        });
    });
</script>

{{-- CSS --}}
<style>
    .list-view {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .list-view .blog-card {
        display: flex;
        align-items: flex-start;
        padding: 1rem;
        text-align: left;
    }

    .list-view .blog-card img {
        width: 150px;
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
