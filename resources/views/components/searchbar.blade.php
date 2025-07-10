<form name="search" id="search" action="{{ $search }}" method="GET" class="flex items-center max-w-sm ms-0">
    <label for="search" class="sr-only">Search</label>
    <div class="relative w-full">
        <input type="text" name="search" id="search" class="bg-white border border-gray-300 text-black text-sm placeholder-black rounded-lg focus:ring-gray-300 focus:border-gray-300 block w-80 ps-5 p-2.5 " placeholder="Search..." value="{{ request('search') }}">
    </div>
    <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-black bg-white rounded-lg border border-gray-300 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
        <span class="sr-only">Search</span>
    </button>
</form>
