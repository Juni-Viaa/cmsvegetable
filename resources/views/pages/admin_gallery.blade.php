@extends('layouts.admin')

@section('title','Admin Gallery')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 rounded-lg mt-14">
        {{-- Breadcrumb --}}
        @include('components.breadcrumb', [
            'pages_name' => 'Gallery'
        ])
        
        {{-- Breadcrumb Second--}}
        @include('components.breadcrumb_child', [
            'child_name' => 'List Gallery'
        ])

        {{-- Error Message --}}
        @include('components.error_message')

        {{-- Modal Add --}}
        @include('components.modal_add', [
            'modal' => 'Add Gallery',
            'modal_name' => 'Create New Gallery',
            'modal_id' => 'add-gallery-modal',
            'form_action' => route('admin_gallery.store'),
            'form_method' => 'POST',
            'fields' => $addFields
        ])

        {{-- Search Bar --}}
        @include('components.searchbar', [
            'search' => route('admin_gallery.index')
        ])

        {{-- Table --}}
        @include('components.table_admin', [
            'modal' => 'Edit',
            'modal_name' => 'Edit Gallery',
            'modal_id' => 'edit-gallery-modal',
            'form_action' => route('admin_gallery.update', ':id'),
            'form_method' => 'PUT',
            'id_field' => 'gallery_id',
            'fields' => $editFields,
            'data' => $data,
            'columns' => $columns,
            'delete_route' => route('admin_gallery.destroy', ':id'),
            'edit_route' => 'admin_gallery.getGallery'
        ])
    </div>
</div>

{{-- JavaScript untuk handling modal dan AJAX --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button click
    document.querySelectorAll('.edit-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const galleryId = this.getAttribute('data-id');
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            
            if (!modal) {
                console.error('Modal not found:', modalId);
                return;
            }
            
            const form = modal.querySelector('form');
            
            // Debug
            console.log('Gallery ID:', galleryId);
            console.log('Modal ID:', modalId);
            
            // Update form action jika diperlukan (untuk kasus dinamis)
            if (form.getAttribute('action').includes(':id')) {
                const actionUrl = form.getAttribute('action').replace(':id', galleryId);
                form.setAttribute('action', actionUrl);
            }
            
            // Fetch gallery data untuk populate form
            fetch(`{{ url('admin_gallery') }}/${galleryId}`, {
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
                    const gallery = data.data;
                    
                    // Populate form fields
                    const titleInput = modal.querySelector('input[name="title"]');
                    const descInput = modal.querySelector('textarea[name="description"]');
                    const categorySelect = modal.querySelector('select[name="category_id"]');
                    
                    if (nameInput) nameInput.value = gallery.title || '';
                    if (descInput) descInput.value = gallery.description || '';
                    if (categorySelect) categorySelect.value = gallery.category_id || '';
                    
                    // Show current image if exists
                    const imagePreview = modal.querySelector('#image-preview');
                    if (gallery.image_path && imagePreview) {
                        imagePreview.src = `/storage/${gallery.image_path}`;
                        imagePreview.style.display = 'block';
                    }
                } else {
                    console.error('Failed to fetch gallery data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching gallery data:', error);
                // Tidak perlu alert, karena form masih bisa digunakan untuk edit
            });
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const galleryId = this.getAttribute('data-id');
            const galleryName = this.getAttribute('data-name');
            
            if (confirm(`Apakah Anda yakin ingin menghapus gallery "${galleryName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin_gallery') }}/${galleryId}`;
                
                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Add method spoofing for DELETE
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

    // Preview image before upload
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
@endsection
