@extends('layouts.admin')

@section('title','Admin Accounts')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 rounded-lg mt-14">

        {{-- Breadcrumb --}}
        @include('components.breadcrumb', [
            'pages_name' => 'Accounts'
        ])

        {{-- Breadcrumb Second --}}
        @include('components.breadcrumb_child', [
            'child_name' => 'List Accounts'
        ])

        {{-- Search Bar --}}
        @include('components.searchbar', [
            'search' => route('admin_account.index')
        ])

        {{-- Table --}}
        @include('components.table_admin', [
            'modal' => 'Edit',
            'modal_name' => 'Edit Account',
            'modal_id' => 'edit-account-modal',
            'form_action' => route('admin_account.update', ':id'),
            'form_method' => 'PATCH',
            'id_field' => 'user_id',
            'fields' => $editFields,
            'data' => $data,
            'columns' => $columns,
            'delete_route' => route('admin_account.destroy', ':id'),
            'edit_route' => 'admin_account.getAccount'
        ])
    </div>
</div>
@endsection
