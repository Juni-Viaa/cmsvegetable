<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Categories') }}
            </h2>
            @include('components.searchbar', [
                'search' => route('admin.categories.index')
            ])
            @include('components.modal_add', [
                'modal' => 'Add Category',
                'modal_name' => 'Create New Category',
                'modal_id' => 'add-category-modal',
                'form_action' => route('admin.categories.store'),
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
                {{-- <div class="flex flex-row items-center justify-between border-b shadow-sm sm:rounded-lg border-gray-400 px-2 py-3 bg-gray-100 font-semibold text-sm uppercase">
                    <div class="w-1/12 text-center border-r border-gray-300">
                        No
                    </div>
                    <div class="w-4/12 pr-4 border-r border-gray-300">
                        Category Name
                    </div>
                    <div class="w-4/12 pr-4 border-r border-gray-300 hidden md:block">
                        Category Type
                    </div>
                    <div class="w-2/12 pr-4 text-center hidden md:block">
                        Actions
                    </div>
                </div> --}}
                @forelse($data as $index => $row)
                    <!-- Baris Data -->
                    <div class="item-card flex flex-row items-center justify-between border-gray-300 py-4 px-2">

                        <!-- Kolom: Nomor Urut -->
                        {{-- <div class="w-1/12 text-center font-medium text-slate-700 border-r border-gray-300">
                            {{ $index + 1 }}
                        </div> --}}


                        <!-- Kolom: Nama Kategori -->
                        <div class="flex flex-col pr-4 border-gray-300">
                                <p class="text-slate-500 text-sm">Name</p>
                                <h3 class="text-indigo-950 text-xl font-bold break-words">{{ $row->category_name }}</h3>
                        </div>

                        <!-- Kolom: Tipe Kategori -->
                        <div class="hidden md:flex flex-col w-4/12 pr-4 border-gray-300 justify-center items-center text-center">
                            <p class="text-slate-500 text-sm">Type</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $row->category_type }}</h3>
                        </div>

                        <!-- Kolom: Tombol Aksi -->
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit Category',
                                'modal_id' => 'edit-category-modal',
                                'form_action' => route('admin.categories.update', ':id'),
                                'form_method' => 'PUT',
                                'id_field' => 'category_id',
                                'fields' => $editFields,
                                'data' => $data,
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'category_id',
                                'delete_route' => route('admin.categories.destroy', ':id'),
                            ])
                        </div>
                    </div>
                @empty
                    <p>No categories found.</p>
                @endforelse
            </div>
            {{ $data->appends(['search' => request('search')])->links() }}
        </div>
    </div>
</x-app-layout>
