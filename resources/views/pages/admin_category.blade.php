@extends('layouts.admin')

@section('title','Admin Category')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 rounded-lg mt-14">

        {{-- Breadcrumb --}}
        @include('components.breadcrumb', [
            'pages_name' => 'Category'
        ])

        {{-- Breadcrumb Second --}}
        @include('components.breadcrumb_child', [
            'child_name' => 'List Category'
        ])

        {{-- Error Message --}}
        @include('components.error_message')

        {{-- Modal Add --}}
        @include('components.modal_add', [
            'modal' => 'Add Category',
            'modal_name' => 'Create New Category',
            'modal_id' => 'add-category-modal',
            'form_action' => route('admin_category.store'),
            'form_method' => 'POST',
            'fields' => $addFields
        ])

        {{-- Search Bar --}}
        @include('components.searchbar', [
            'search' => route('admin_category.index')
        ])

        {{-- Table --}}
        @include('components.table_admin', [
            'modal' => 'Edit',
            'modal_name' => 'Edit Category',
            'modal_id' => 'edit-category-modal',
            'form_action' => route('admin_category.update', ':id'),
            'form_method' => 'PUT',
            'id_field' => 'category_id',
            'fields' => $editFields,
            'data' => $data,
            'columns' => $columns,
            'delete_route' => route('admin_category.destroy', ':id'),
            'edit_route' => 'admin_category.getCategory'
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
            const categoryId = this.getAttribute('data-id');
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            
            if (!modal) {
                console.error('Modal not found:', modalId);
                return;
            }
            
            const form = modal.querySelector('form');
            
            // Debug
            console.log('Category ID:', categoryId);
            console.log('Modal ID:', modalId);
            
            // Update form action jika diperlukan (untuk kasus dinamis)
            if (form.getAttribute('action').includes(':id')) {
                const actionUrl = form.getAttribute('action').replace(':id', categoryId);
                form.setAttribute('action', actionUrl);
            }
            
            // Fetch category data untuk populate form
            fetch(`{{ url('admin_category') }}/${categoryId}`, {
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
                    const category = data.data;
                    
                    // Populate form fields
                    const categoryInput = modal.querySelector('input[name="category_name"]');
                    const typeSelect = modal.querySelector('select[name="category_id"]');
                    
                    if (categoryInput) categoryInput.value = category.category_name || '';
                    if (categorySelect) categorySelect.value = category_id || '';

                } else {
                    console.error('Failed to fetch category data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching category data:', error);
                // Tidak perlu alert, karena form masih bisa digunakan untuk edit
            });
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-id');
            const categoryName = this.getAttribute('data-name');
            
            if (confirm(`Apakah Anda yakin ingin menghapus category "${categoryName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin_category') }}/${categoryId}`;
                
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
});
</script>
@endpush
@endsection
