@extends('layouts.admin')

@section('title','Admin Banner')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 rounded-lg mt-14">

        {{-- Breadcrumb --}}
        @include('components.breadcrumb', [
            'pages_name' => 'Banner'
        ])

        {{-- Breadcrumb Second --}}
        @include('components.breadcrumb_child', [
            'child_name' => 'List Banner'
        ])

        {{-- Error Message --}}
        @include('components.error_message')

        {{-- Modal Add --}}
        @include('components.modal_add', [
            'modal' => 'Add Banner',
            'modal_name' => 'Create New Banner',
            'modal_id' => 'add-banner-modal',
            'form_action' => route('admin_banner.store'),
            'form_method' => 'POST',
            'fields' => $addFields
        ])

        {{-- Table --}}
        @include('components.table_admin', [
            'modal' => 'Edit',
            'modal_name' => 'Edit Banner',
            'modal_id' => 'edit-banner-modal',
            'form_action' => route('admin_banner.update', ':id'),
            'form_method' => 'PATCH',
            'id_field' => 'banner_id',
            'fields' => $editFields,
            'data' => $data,
            'columns' => $columns,
            'delete_route' => route('admin_banner.destroy', ':id'),
            'edit_route' => 'admin_banner.getBanner'
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
            const bannerId = this.getAttribute('data-id');
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            
            if (!modal) {
                console.error('Modal not found:', modalId);
                return;
            }
            
            const form = modal.querySelector('form');
            
            // Debug
            console.log('Banner ID:', bannerId);
            console.log('Modal ID:', modalId);
            
            // Update form action jika diperlukan (untuk kasus dinamis)
            if (form.getAttribute('action').includes(':id')) {
                const actionUrl = form.getAttribute('action').replace(':id', bannerId);
                form.setAttribute('action', actionUrl);
            }
            
            // Fetch banner data untuk populate form
            fetch(`{{ url('admin_banner') }}/${bannerId}`, {
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
                    const banner = data.data;
                    
                    // Show current image if exists
                    const imagePreview = modal.querySelector('#image-preview');
                    if (banner.image_path && imagePreview) {
                        imagePreview.src = `/storage/${banner.image_path}`;
                        imagePreview.style.display = 'block';
                    }
                } else {
                    console.error('Failed to fetch banner data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching banner data:', error);
                // Tidak perlu alert, karena form masih bisa digunakan untuk edit
            });
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const bannerId = this.getAttribute('data-id');
            
            if (confirm(`Apakah Anda yakin ingin menghapus banner ini ?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin_banner') }}/${bannerId}`;
                
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