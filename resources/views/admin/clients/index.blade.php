<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Clients') }}
            </h2>
            @include('components.searchbar', [
                'search' => route('admin.clients.index')
            ])
            @include('components.modal_add', [
                'modal' => 'Add Data Client',
                'modal_name' => 'Create Data Client',
                'modal_id' => 'add-client-modal',
                'form_action' => route('admin.clients.store'),
                'form_method' => 'POST',
                'fields' => $addFields,
            ])
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.error_message')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col">
                <!-- Header Kolom -->
                <div
                    class="flex flex-row items-center justify-between border-b shadow-sm sm:rounded-lg border-gray-400 px-2 py-3 bg-gray-100 font-semibold text-sm uppercase">
                    <div class="w-1/12 text-center border-r border-gray-300">
                        No
                    </div>
                    <div class="w-4/12 pl-4 border-r border-gray-300">
                        Client Name
                    </div>
                    <div class="w-4/12 border-r text-center border-gray-300 hidden md:block">
                        Date Created
                    </div>
                    <div class="w-2/12 px-4 border-r text-center border-gray-300 hidden md:block">
                        Image
                    </div>
                    <div class="w-1/12 pl-1 text-center hidden md:block">
                        Actions
                    </div>
                </div>
                @forelse($data as $index => $row)
                    <!-- Baris Data -->
                    <div
                        class="item-card flex flex-row items-center justify-between border-b border-gray-300 py-2 px-2">

                        <!-- Kolom: Nomor Urut -->
                        <div class="w-1/12 text-center font-medium text-slate-700 border-r border-gray-300">
                            {{ $index + 1 }}
                        </div>
                        <!-- Kolom: Nama Client -->
                        <div class="flex flex-col w-4/12 pl-4 border-r border-gray-300">
                            <h3 class="text-indigo-950 text-xl font-bold break-words">{{ $row->name }}</h3>
                        </div>

                        <!-- Kolom: Tanggal -->
                        <div class="hidden md:flex flex-col text-center w-4/12 border-r border-gray-300">
                            <h3 class="text-indigo-950 text-xl font-bold">
                                {{ $row->created_at ? $row->created_at->format('d M Y') : '-' }}</h3>
                        </div>

                        <!-- Kolom: Preview Gambar -->
                        <img src="{{ Storage::url($row->avatar) }}" alt=""
                            class="hidden md:flex w-2/12 border-gray-300">

                        <!-- Kolom: Tombol Aksi -->
                        <div class="hidden md:flex flex-col items-center justify-center w-1/12 border-l gap-y-2">
                            @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit Data Client',
                                'modal_id' => 'edit-client-modal',
                                'form_action' => route('admin.clients.update', ':id'),
                                'form_method' => 'PUT',
                                'id_field' => 'client_id',
                                'fields' => $editFields,
                                'data' => $data,
                                'edit_route' => 'admin.clients.getClient',
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'client_id',
                                'delete_route' => route('admin.clients.destroy', ':id'),
                            ])
                        </div>
                    </div>
                @empty
                    <p>No clients found.</p>
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
                                    const clientId = this.getAttribute('data-id');
                                    const modalId = this.getAttribute('data-modal-target');
                                    const modal = document.getElementById(modalId);

                                    if (!modal) {
                                        console.error('Modal not found:', modalId);
                                        return;
                                    }

                                    const form = modal.querySelector('form');

                                    // Debug
                                    console.log('Client ID:', clientId);
                                    console.log('Modal ID:', modalId);

                                    // Update form
                                    if (form.getAttribute('action').includes(':id')) {
                                        const actionUrl = form.getAttribute('action').replace(':id', clientId);
                                        form.setAttribute('action', actionUrl);

                                        // Ambil data 
                                        fetch({{ url('admin.clients') }} / $ {
                                                clientId
                                            }, {
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
                                                    const client = data.data;

                                                    // Populate form fields dari response JSON
                                                    const nameInput = modal.querySelector('input[name="name"]');
                                                    const occupationInput = modal.querySelector(
                                                        'input[name="occupation"]');

                                                    if (nameInput) nameInput.value = admin.clients.name || '';
                                                    if (occupationInput) occupationInput.value = admin.clinets
                                                        .occupation || '';

                                                    // Tampilkan preview gambar jika ada
                                                    const imagePreview = modal.querySelector('#image-preview');
                                                    if (admin.clients.image_path && imagePreview) {
                                                        imagePreview.src = `/storage/${clients.image_path}`;
                                                        imagePreview.style.display = 'block';
                                                    }
                                                } else {
                                                    console.error('Failed to fetch Data Client data:', data);
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Error fetching Data Client data:', error);
                                            });
                                    });
                            });

                        // Handle delete button click
                        document.querySelectorAll('.delete-btn').forEach(function(button) {
                            button.addEventListener('click', function() {
                                const clientId = this.getAttribute('data-id');
                                const clientName = this.getAttribute('data-name');

                                if (confirm(
                                        `Apakah Anda yakin ingin menghapus Data Client "${clientName}"?`)) {
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = `{{ url('admin.clients') }}/${clientId}`;

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
