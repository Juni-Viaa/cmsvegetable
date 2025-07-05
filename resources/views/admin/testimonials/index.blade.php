<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Testimonials') }}
            </h2>
            @include('components.modal_add', [
                'modal' => 'Add Testimonial',
                'modal_name' => 'Create Testimonial',
                'modal_id' => 'add-testimonial-modal',
                'form_action' => route('admin.testimonials.store'),
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
                            <h3 class="text-indigo-950 text-xl font-bold">{{$row->client->name}}</h3>
                        </div>
                    </div> 
                    <div  class="hidden md:flex flex-col">
                        <p class="text-slate-500 text-sm">Date</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{$row->created_at}}</h3>
                    </div>
                    <div class="hidden md:flex flex-row items-center gap-x-3">
                        @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit Testimonial',
                                'modal_id' => 'edit-testimonial-modal',
                                'form_action' => route('admin.testimonials.update', ':id'), 
                                'form_method' => 'PUT',
                                'id_field' => 'testimonial_id',
                                'fields' => $editFields,
                                'data' => $data,
                                'edit_route' => 'admin.testimonials.getTestimonial',
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'testimonial_id',
                                'delete_route' => route('admin.testimonials.destroy', ':id'),
                            ])
                    </div>
                </div>
                @empty
                <p>No testimonials found.</p>
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
            const testId = this.getAttribute('data-id');
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            
            if (!modal) {
                console.error('Modal not found:', modalId);
                return;
            }
            
            const form = modal.querySelector('form');

             // Debug
            console.log('Testimonial ID:', testId);
            console.log('Modal ID:', modalId);
            
            // Update form
            if (form.getAttribute('action').includes(':id')) {
                const actionUrl = form.getAttribute('action').replace(':id', testId);
                form.setAttribute('action', actionUrl);
            
            // Ambil data 
            fetch({{ url('admin.testimonials') }}/${testId}, {
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
                    const test = data.data;
                    
                    // Populate form fields dari response JSON
                    const messageInput = modal.querySelector('input[name="message"]');
                    
                    if (messageInput) messageInput.value = admin.testimonials.message || '';
                    
                    // Tampilkan preview gambar jika ada
                    const imagePreview = modal.querySelector('#image-preview');
                    if (admin.testimonials.image_path && imagePreview) {
                        imagePreview.src = `/storage/${testimonials.image_path}`;
                        imagePreview.style.display = 'block';
                    }
                } else {
                    console.error('Failed to fetch Testimonial data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching Testimonial data:', error);
            });
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const testId = this.getAttribute('data-id');
            const testName = this.getAttribute('data-name');
            
            if (confirm(`Apakah Anda yakin ingin menghapus Testimonial "${test}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin.testimonials') }}/${testId}`;
                
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

