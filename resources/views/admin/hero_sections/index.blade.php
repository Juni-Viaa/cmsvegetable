<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Hero Sections') }}
            </h2>
            @include('components.searchbar', [
                'search' => route('admin.hero_sections.index')
            ])
            @include('components.modal_add', [
                'modal' => 'Add Hero Section',
                'modal_name' => 'Create Hero Section',
                'modal_id' => 'add-hero-modal',
                'form_action' => route('admin.hero_sections.store'),
                'form_method' => 'POST',
                'fields' => $addFields,
            ])
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.error_message')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col">
                @forelse($data as $index => $row)
                    <!-- Baris Data -->
                    <div
                        class="item-card flex flex-row items-center justify-between border-gray-300 py-2 px-2">
                        
                        <!-- Kolom: Nomor Urut -->
                        {{-- <div class="w-1/12 text-center font-medium text-slate-700 border-r border-gray-300">
                            {{ $index + 1 }}
                        </div> --}}

                        <!-- Kolom: Preview Gambar -->
                        {{-- This image is shown as the "Preview Gambar" (Banner Image) column for each hero section row --}}
                        <div class="flex flex-row items-center w-0 min-w-[400px] gap-x-3">
                            <img src="{{ Storage::url($row->image_path) }}" alt="Banner Image"
                                class="flex-none rounded-2xl object-cover w-[100px] h-[100px]">
                            <!-- Kolom: Nama Hero Section -->
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-xl font-bold break-words line-clamp-2">{{ $row->heading }}</h3>
                                {{-- <h3 class="text-indigo-950 text-sm font-bold break-words">{{ $row->subheading }}</h3> --}}
                            </div>
                        </div>
            
                        <!-- Kolom: Tanggal -->
                        <div class="hidden md:flex flex-col justify-center items-center text-center w-4/12 border-gray-300">
                            <p class="text-slate-500 text-sm">Date</p>
                            <h3 class="text-indigo-950 text-xl font-bold">
                                {{ $row->created_at ? $row->created_at->format('d M Y') : '-' }}</h3>
                        </div>

                        <!-- Kolom: Tombol Aksi -->
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit Hero Section',
                                'modal_id' => 'edit-hero-modal',
                                'form_action' => route('admin.hero_sections.update', ':id'),
                                'form_method' => 'PUT',
                                'id_field' => 'hero_id',
                                'fields' => $editFields,
                                'data' => $data,
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'hero_id',
                                'delete_route' => route('admin.hero_sections.destroy', ':id'),
                            ])
                        </div>
                    </div>
                @empty
                    <p>No hero sections found.</p>
                @endforelse
            </div>
            {{ $data->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</x-app-layout>
