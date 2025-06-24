@extends('layouts.admin')

@section('title','Admin Blog')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 rounded-lg mt-14">

        {{-- Breadcrumb --}}
        @include('components.breadcrumb', [
            'pages_name' => 'Blog'
        ])

        {{-- Breadcrumb Second--}}
        @include('components.breadcrumb_child', [
            'child_name' => 'List Blog'
        ])

        {{-- Error Message --}}
        @include('components.error_message')

        {{-- Modal Add --}}
        @include('components.modal_add', [
            'modal' => 'Add Blog',
            'modal_name' => 'Create New Blog',
            'modal_id' => 'add-blog-modal',
            'form_action' => route('admin_blog.store'),
            'form_method' => 'POST',
            'fields' => $addFields
        ])

        {{-- Search Bar --}}
        @include('components.searchbar', [
            'search' => route('admin_blog.index')
        ])

        {{-- Table --}}
        @include('components.table_admin', [
            'modal' => 'Edit',
            'modal_name' => 'Edit Blog',
            'modal_id' => 'edit-blog-modal',
            'form_action' => route('admin_blog.update', ':id'),
            'form_method' => 'PUT',
            'id_field' => 'blog_id',
            'fields' => $editFields,
            'data' => $data,
            'columns' => $columns,
            'delete_route' => route('admin_blog.destroy', ':id'),
            'edit_route' => 'admin_blog.getBlog'
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
            const blogId = this.getAttribute('data-id');
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            
            if (!modal) {
                console.error('Modal not found:', modalId);
                return;
            }
            
            const form = modal.querySelector('form');
            
            // Debug
            console.log('Blog ID:', blogId);
            console.log('Modal ID:', modalId);
            
            // Update form action jika diperlukan (untuk kasus dinamis)
            if (form.getAttribute('action').includes(':id')) {
                const actionUrl = form.getAttribute('action').replace(':id', blogId);
                form.setAttribute('action', actionUrl);
            }
            
            // Fetch blog data untuk populate form
            fetch(`{{ url('admin_blog') }}/${blogId}`, {
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
                    const blog = data.data;
                    
                    // Populate form fields
                    const titleInput = modal.querySelector('input[name="title"]');
                    const contentInput = modal.querySelector('textarea[name="content"]');
                    const categorySelect = modal.querySelector('select[name="category_id"]');
                    
                    if (nameInput) titleInput.value = blog.title || '';
                    if (descInput) contentInput.value = blog.content || '';
                    if (categorySelect) categorySelect.value = blog.category_id || '';
                    
                    // Show current image if exists
                    const imagePreview = modal.querySelector('#image-preview');
                    if (blog.image_path && imagePreview) {
                        imagePreview.src = `/storage/${blog.image_path}`;
                        imagePreview.style.display = 'block';
                    }
                } else {
                    console.error('Failed to fetch vlog data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching blog data:', error);
                // Tidak perlu alert, karena form masih bisa digunakan untuk edit
            });
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const blogId = this.getAttribute('data-id');
            const blogTitle = this.getAttribute('data-title');
            
            if (confirm(`Apakah Anda yakin ingin menghapus blog "${blogTitle}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin_blog') }}/${blogId}`;
                
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
