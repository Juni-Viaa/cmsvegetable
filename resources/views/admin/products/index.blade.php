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
            'form_action' => route('admin.products.store'), // POST ke controller
            'form_method' => 'POST',
            'fields' => $addFields // Diambil dari AdminProductController@index
        ])

        {{-- Search Bar --}}
        @include('components.searchbar', [
            // Pencarian dikirim ke AdminProductController@index
            'search' => route('admin.products.index')
        ])

        {{-- Table --}}
        @include('components.table_admin', [
            // Modal edit, terkoneksi ke AdminProductController@update dan @getProduct
            'modal' => 'Edit',
            'modal_name' => 'Edit Product',
            'modal_id' => 'edit-product-modal',
            'form_action' => route('admin.products.update', ':id'), // PATCH ke controller
            'form_method' => 'PUT',
            'id_field' => 'product_id', // Kolom unik dari model Product
            'fields' => $editFields, // Diisi dari AdminProductController@index
            'data' => $data, // Data hasil paginate() dari model Product
            'columns' => $columns,
            'delete_route' => route('admin.products.destroy', ':id'), // DELETE ke controller
            'edit_route' => 'product.getProduct' // AJAX panggil AdminProductController@getProduct
        ])
    </div>
</div>