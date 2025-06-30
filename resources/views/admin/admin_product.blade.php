@extends('layouts.admin')

@section('title','Admin Product')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 rounded-lg mt-14">
        
        {{-- Breadcrumb --}}
        @include('components.breadcrumb', [
            'pages_name' => 'Product'
        ])

        {{-- Breadcrumb Second --}}
        @include('components.breadcrumb_child', [
            'child_name' => 'List Product'
        ])

        {{-- Error Message --}}
        @include('components.error_message')

        {{-- Modal Add --}}
        @include('components.modal_add', [
            // Terkoneksi ke AdminProductController@store
            'modal' => 'Add Product',
            'modal_name' => 'Create New Product',
            'modal_id' => 'add-product-modal',
            'form_action' => route('product.store'), // POST ke controller
            'form_method' => 'POST',
            'fields' => $addFields // Diambil dari AdminProductController@index
        ])

        {{-- Search Bar --}}
        @include('components.searchbar', [
            // Pencarian dikirim ke AdminProductController@index
            'search' => route('product.index')
        ])

        {{-- Table --}}
        @include('components.table_admin', [
            // Modal edit, terkoneksi ke AdminProductController@update dan @getProduct
            'modal' => 'Edit',
            'modal_name' => 'Edit Product',
            'modal_id' => 'edit-product-modal',
            'form_action' => route('product.update', ':id'), // PATCH ke controller
            'form_method' => 'PATCH',
            'id_field' => 'product_id', // Kolom unik dari model Product
            'fields' => $editFields, // Diisi dari AdminProductController@index
            'data' => $data, // Data hasil paginate() dari model Product
            'columns' => $columns,
            'delete_route' => route('product.destroy', ':id'), // DELETE ke controller
            'edit_route' => 'product.getProduct' // AJAX panggil AdminProductController@getProduct
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
            const productId = this.getAttribute('data-id');
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            
            if (!modal) {
                console.error('Modal not found:', modalId);
                return;
            }
            
            const form = modal.querySelector('form');

             // Debug
            console.log('Product ID:', productId);
            console.log('Modal ID:', modalId);
            
            // Update form action: mengganti ':id' dengan ID produk nyata
            if (form.getAttribute('action').includes(':id')) {
                const actionUrl = form.getAttribute('action').replace(':id', productId);
                form.setAttribute('action', actionUrl); // Terhubung ke AdminProductController@update
            }
            
            // Ambil data produk dari AdminProductController@getProduct (via fetch)
            fetch({{ url('product') }}/${productId}, {
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
                    const product = data.data;
                    
                    // Populate form fields dari response JSON
                    const nameInput = modal.querySelector('input[name="name"]');
                    const descInput = modal.querySelector('textarea[name="description"]');
                    const categorySelect = modal.querySelector('select[name="category_id"]');
                    
                    if (nameInput) nameInput.value = product.name || '';
                    if (descInput) descInput.value = product.description || '';
                    if (categorySelect) categorySelect.value = product.category_id || '';
                    
                    // Tampilkan preview gambar jika ada
                    const imagePreview = modal.querySelector('#image-preview');
                    if (product.image_path && imagePreview) {
                        imagePreview.src = `/storage/${product.image_path}`;
                        imagePreview.style.display = 'block';
                    }
                } else {
                    console.error('Failed to fetch product data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching product data:', error);
            });
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            
            if (confirm(`Apakah Anda yakin ingin menghapus product "${productName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('product') }}/${productId}`; // Terkoneksi ke AdminProductController@destroy
                
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
@endsection
