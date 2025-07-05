<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Statistics') }}
            </h2>
            @include('components.modal_add', [
                'modal' => 'Add Company Statistic',
                'modal_name' => 'Create Company Statistic',
                'modal_id' => 'add-statistic-modal',
                'form_action' => route('admin.statistics.store'),
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
                        <img src="{{Storage::url($row->icon)}}" alt="" class="rounded-2xl object-cover w-[90px] h-[90px]">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">
                                {{$row->name}}
                            </h3>
                        </div>
                    </div> 
                    <div  class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Date</p>
                        <h3 class="text-indigo-950 text-xl font-bold">
                            {{$row->created_at->format('M d, Y')}}
                        </h3>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit statistics',
                                'modal_id' => 'edit-statistic-modal',
                                'form_action' => route('admin.statistics.update', ':id'), 
                                'form_method' => 'PUT',
                                'id_field' => 'statistic_id',
                                'fields' => $editFields,
                                'data' => $data,
                                'edit_route' => 'admin.statistics.getStat',
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'statistic_id',
                                'delete_route' => route('admin.statistics.destroy', ':id'),
                            ])
                    </div>
                </div> 
                @empty
                <p>No statistics found.</p>
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
            const statId = this.getAttribute('data-id');
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            
            if (!modal) {
                console.error('Modal not found:', modalId);
                return;
            }
            
            const form = modal.querySelector('form');

             // Debug
            console.log('Statistic ID:', statId);
            console.log('Modal ID:', modalId);
            
            // Update form
            if (form.getAttribute('action').includes(':id')) {
                const actionUrl = form.getAttribute('action').replace(':id', statId);
                form.setAttribute('action', actionUrl);
            
            // Ambil data 
            fetch({{ url('admin.statistics') }}/${statId}, {
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
                    const stat = data.data;
                    
                    // Populate form fields dari response JSON
                    const nameInput = modal.querySelector('input[name="name"]');
                    const goalInput = modal.querySelector('input[name="goal"]');
                    
                    if (nameInput) nameInput.value = admin.statistics.name || '';
                    if (goalInput) goalInput.value = admin.statistics.goal || '';
                    
                    // Tampilkan preview gambar jika ada
                    const imagePreview = modal.querySelector('#image-preview');
                    if (admin.statistics.image_path && imagePreview) {
                        imagePreview.src = `/storage/${statistics.image_path}`;
                        imagePreview.style.display = 'block';
                    }
                } else {
                    console.error('Failed to fetch Statistic data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching Statistic data:', error);
            });
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const statId = this.getAttribute('data-id');
            const statName = this.getAttribute('data-name');
            
            if (confirm(`Apakah Anda yakin ingin menghapus Statistic "${statName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin.statistics') }}/${statId}`;
                
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
