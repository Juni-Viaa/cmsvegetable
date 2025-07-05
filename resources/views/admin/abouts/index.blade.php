<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Vission & Mission') }}
            </h2>
            @include('components.modal_add', [
                'modal' => 'Add Vision & Mission',
                'modal_name' => 'Create Vision & Mission',
                'modal_id' => 'add-vm-modal',
                'form_action' => route('admin.abouts.store'),
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
                        <p class="text-slate-500 text-sm">Type</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{$row->type}}</h3>
                    </div>
                    <div  class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Date</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{$row->created_at}}</h3>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit Vision & Mission',
                                'modal_id' => 'edit-vm-modal',
                                'form_action' => route('admin.abouts.update', ':id'), 
                                'form_method' => 'PUT',
                                'id_field' => 'about_id',
                                'fields' => $editFields,
                                'data' => $data,
                                'edit_route' => 'admin.abouts.getAbout',
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'about_id',
                                'delete_route' => route('admin.abouts.destroy', ':id'),
                            ])
                    </div>
                </div> 
                @empty
                <p>No abouts found.</p>
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
            const aboutId = this.getAttribute('data-id');
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            
            if (!modal) {
                console.error('Modal not found:', modalId);
                return;
            }
            
            const form = modal.querySelector('form');

             // Debug
            console.log('About ID:', aboutId);
            console.log('Modal ID:', modalId);
            
            // Update form
            if (form.getAttribute('action').includes(':id')) {
                const actionUrl = form.getAttribute('action').replace(':id', aboutId);
                form.setAttribute('action', actionUrl);
            
            // Ambil data 
            fetch({{ url('admin.abouts') }}/${aboutId}, {
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
                    const about = data.data;
                    
                    // Populate form fields dari response JSON
                    const nameInput = modal.querySelector('input[name="name"]');
                    const typeSelect = modal.querySelector('select[name="type"]');

                    
                    if (nameInput) headingInput.value = admin.abouts.name || '';
                    if (typeSelect) typeSelect.value = type || '';
                    
                    // Tampilkan preview gambar jika ada
                    const imagePreview = modal.querySelector('#image-preview');
                    if (admin.abouts.image_path && imagePreview) {
                        imagePreview.src = `/storage/${abouts.image_path}`;
                        imagePreview.style.display = 'block';
                    }
                } else {
                    console.error('Failed to fetch About data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching About data:', error);
            });
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const aboutId = this.getAttribute('data-id');
            const aboutName = this.getAttribute('data-name');
            
            if (confirm(`Apakah Anda yakin ingin menghapus Abouts "${aboutName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin.abouts') }}/${aboutId}`;
                
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
