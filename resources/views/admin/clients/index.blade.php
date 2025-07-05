<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Clients') }}
            </h2>
            @include('components.modal_add', [
                'modal' => 'Add Data Client',
                'modal_name' => 'Create Data Client',
                'modal_id' => 'add-client-modal',
                'form_action' => route('admin.clients.store'),
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
                        <p class="text-slate-500 text-sm">Occupation</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{$row->occupation}}</h3>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit Data Client',
                                'modal_id' => 'edit-client-modal',
                                'form_action' => route('admin.clients.update', ':id'), 
                                'form_method' => 'PUT',
                                'id_field' => 'client_id',
                                'fields' => $editFields,
                                'data' => $data,
                                'edit_route' => 'admin.clients.getClient',
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'client_id',
                                'delete_route' => route('admin.clients.destroy', ':id'),
                            ])
                    </div>
                </div> 
                @empty
                <p>No clients found.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button click
    document.querySelectorAll('.edit-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const clientId = this.getAttribute('data-id');
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            
            if (!modal) {
                console.error('Modal not found:', modalId);
                return;
            }
            
            const form = modal.querySelector('form');

             // Debug
            console.log('Client ID:', clientId);
            console.log('Modal ID:', modalId);
            
            // Update form
            if (form.getAttribute('action').includes(':id')) {
                const actionUrl = form.getAttribute('action').replace(':id', clientId);
                form.setAttribute('action', actionUrl);
            
            // Ambil data 
            fetch({{ url('admin.clients') }}/${clientId}, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const client = data.data;
                    
                    // Populate form fields dari response JSON
                    const nameInput = modal.querySelector('input[name="name"]');
                    const occupationInput = modal.querySelector('input[name="occupation"]');
                    
                    if (nameInput) nameInput.value = admin.clients.name || '';
                    if (occupationInput) occupationInput.value = admin.clinets.occupation || '';
                    
                    // Tampilkan preview gambar jika ada
                    const imagePreview = modal.querySelector('#image-preview');
                    if (admin.clients.image_path && imagePreview) {
                        imagePreview.src = `/storage/${clients.image_path}`;
                        imagePreview.style.display = 'block';
                    }
                } else {
                    console.error('Failed to fetch Data Client data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching Data Client data:', error);
            });
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const clientId = this.getAttribute('data-id');
            const clientName = this.getAttribute('data-name');
            
            if (confirm(`Apakah Anda yakin ingin menghapus Data Client "${clientName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin.clients') }}/${clientId}`;
                
                // Tambah CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Tambah method spoofing DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // Preview image sebelum upload
    document.querySelectorAll('input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function() {
            const file = this.files[0];
            const previewId = this.getAttribute('data-preview');
            
            if (file && previewId) {
                const preview = document.getElementById(previewId);
                if (preview) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    
                    reader.readAsDataURL(file);
                }
            }
        });
    });
});
</script>
@endpush
