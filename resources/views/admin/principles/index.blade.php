<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Principles') }}
            </h2>
            @include('components.modal_add', [
                'modal' => 'Add Principles',
                'modal_name' => 'Create Principles',
                'modal_id' => 'add-principles-modal',
                'form_action' => route('admin.principles.store'),
                'form_method' => 'POST',
                'fields' => $addFields,
            ])
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.error_message')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                @forelse($data as $row)
                <div class="item-card flex flex-row justify-between items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <img src="{{Storage::url($row->thumbnail)}}" alt="" class="rounded-2xl object-cover w-[90px] h-[90px]">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">{{$row->name}}</h3>
                        </div>
                    </div> 
                    <div  class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Date</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{$row->created_at}}</h3>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit Principles',
                                'modal_id' => 'edit-principles-modal',
                                'form_action' => route('admin.principles.update', ':id'), 
                                'form_method' => 'PUT',
                                'id_field' => 'principle_id',
                                'fields' => $editFields,
                                'data' => $data,
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'principle_id',
                                'delete_route' => route('admin.principles.destroy', ':id'),
                            ])
                    </div>
                </div> 
                @empty
                <p>No principles found.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
