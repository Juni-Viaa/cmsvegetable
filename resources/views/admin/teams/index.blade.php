<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Teams') }}
            </h2>
            @include('components.modal_add', [
                'modal' => 'Add Team Member',
                'modal_name' => 'Create Team Member',
                'modal_id' => 'add-team-modal',
                'form_action' => route('admin.teams.store'),
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
                        <img src="{{Storage::url($row->avatar)}}" alt="" class="rounded-2xl object-cover w-[90px] h-[90px]">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">{{$row->name}}</h3>
                        </div>
                    </div> 
                    <div  class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Location</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{$row->location}}</h3>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit Team Member',
                                'modal_id' => 'edit-team-modal',
                                'form_action' => route('admin.teams.update', ':id'), 
                                'form_method' => 'PUT',
                                'id_field' => 'team_id',
                                'fields' => $editFields,
                                'data' => $data,
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'team_id',
                                'delete_route' => route('admin.teams.destroy', ':id'),
                            ])
                    </div>
                </div> 
                @empty
                <p>No teams found.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
