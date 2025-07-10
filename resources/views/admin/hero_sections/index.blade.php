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
                <!-- Header Kolom -->
                <div class="flex flex-row items-center justify-between border-b shadow-sm sm:rounded-lg border-gray-400 px-2 py-3 bg-gray-100 font-semibold text-sm uppercase">
                    <div class="w-1/12 text-center border-r border-gray-300">
                        No
                    </div>
                    <div class="w-4/12 pl-4 border-r border-gray-300">
                        Hero Section Name
                    </div>
                    <div class="w-4/12 border-r text-center border-gray-300 hidden md:block">
                        Date Created
                    </div>
                    <div class="w-2/12 px-4 border-r text-center border-gray-300 hidden md:block">
                        Image
                    </div>
                    <div class="w-1/12 pl-1 text-center hidden md:block">
                        Actions
                    </div>
                </div>
                @forelse($data as $index => $row)
                    <!-- Baris Data -->
                    <div
                        class="item-card flex flex-row items-center justify-between border-b border-gray-300 py-2 px-2">

                        <!-- Kolom: Nomor Urut -->
                        <div class="w-1/12 text-center font-medium text-slate-700 border-r border-gray-300">
                            {{ $index + 1 }}
                        </div>
                        <!-- Kolom: Nama Hero Section -->
                        <div class="flex flex-col w-4/12 pl-4 border-r border-gray-300">
                            <h3 class="text-indigo-950 text-xl font-bold break-words">{{ $row->heading }}</h3>
                        </div>

                        <!-- Kolom: Tanggal -->
                        <div class="hidden md:flex flex-col text-center w-4/12 border-r border-gray-300">
                            <h3 class="text-indigo-950 text-xl font-bold">
                                {{ $row->created_at ? $row->created_at->format('d M Y') : '-' }}</h3>
                        </div>

                        <!-- Kolom: Preview Gambar -->
                        <img src="{{ Storage::url($row->image_path) }}" alt=""
                            class="hidden md:flex w-2/12 border-gray-300">

                        <!-- Kolom: Tombol Aksi -->
                        <div class="hidden md:flex flex-col items-center justify-center w-1/12 border-l gap-y-2">
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
        </div>
    </div>
</x-app-layout>
