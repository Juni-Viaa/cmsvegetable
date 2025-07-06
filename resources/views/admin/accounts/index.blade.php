<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Accounts') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                @forelse($data as $row)
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="flex flex-row items-center gap-x-3">
                            <img src="{{ Storage::url($row->banner) }}" alt=""
                                class="rounded-2xl object-cover w-[90px] h-[90px]">
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-xl font-bold">{{ $row->heading }}</h3>
                            </div>
                        </div>
                        <div class="hidden md:flex flex-col">
                            <p class="text-slate-500 text-sm">Date</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $row->created_at }}</h3>
                        </div>
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit Account',
                                'modal_id' => 'edit-account-modal',
                                'form_action' => route('admin.accounts.update', ':id'),
                                'form_method' => 'PUT',
                                'id_field' => 'user_id',
                                'fields' => $editFields,
                                'data' => $data,
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'user_id',
                                'delete_route' => route('admin.accounts.destroy', ':id'),
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
