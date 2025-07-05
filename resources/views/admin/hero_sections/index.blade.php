<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Hero Sections') }}
            </h2>
            @include('components.modal_add', [
                'modal' => 'Add Hero Section',
                'modal_name' => 'Create Hero Section',
                'modal_id' => 'add-hero-modal',
                'form_action' => route('admin.hero_sections.store'),
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
                            <img src="{{ Storage::url($row->image_path) }}" alt=""
                                class="rounded-2xl object-cover w-[90px] h-[90px]">
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-xl font-bold">{{ $row->heading }}</h3>
                            </div>
                        </div>
                        <div class="hidden md:flex flex-col">
                            <p class="text-slate-500 text-sm">Date</p>
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $row->created_at }}</h3>
                        </div>
                        <div class="hidden md:flex flex-row items-center gap-x-3">
                            @include('components.modal_edit', [
                                'modal' => 'Edit',
                                'modal_name' => 'Edit Hero Section',
                                'modal_id' => 'edit-hero-modal',
                                'form_action' => route('admin.hero_sections.update', ':id'), 
                                'form_method' => 'PUT',
                                'id_field' => 'hero_id',
                                'fields' => $editFields,
                                'data' => $data,
                                'edit_route' => 'admin.hero_sections.getHero',
                            ])
                            @include('components.modal_delete', [
                                'id_field' => 'hero_id',
                                'delete_route' => route('admin.hero_sections.destroy', ':id'),
                            ])
                        </div>
                    </div>
                @empty
                    <p>No hero sections found.</p>
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
            const heroId = this.getAttribute('data-id');
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            
            if (!modal) {
                console.error('Modal not found:', modalId);
                return;
            }
            
            const form = modal.querySelector('form');

             // Debug
            console.log('Hero ID:', heroId);
            console.log('Modal ID:', modalId);
            
            // Update form
            if (form.getAttribute('action').includes(':id')) {
                const actionUrl = form.getAttribute('action').replace(':id', heroId);
                form.setAttribute('action', actionUrl);
            
            // Ambil data 
            fetch({{ url('admin.hero_sections') }}/${heroId}, {
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
                    const hero = data.data;
                    
                    // Populate form fields dari response JSON
                    const headingInput = modal.querySelector('input[name="heading"]');
                    const subheadingInput = modal.querySelector('input[name="subheading"]');
                    const achievementInput = modal.querySelector('input[name="achievement"]');
                    const pathInput = modal.querySelector('input[name="path_video"]');
                    
                    if (headingInput) headingInput.value = admin.hero_sections.heading || '';
                    if (subheadingInput) subheadingInput.value = admin.hero_sections.subheading || '';
                    if (achievementInput) achievementInput.value = admin.hero_sections.achievementInput || '';
                    if (pathInput) pathInput.value = admin.hero_section.pathInput || '';
                    
                    // Tampilkan preview gambar jika ada
                    const imagePreview = modal.querySelector('#image-preview');
                    if (admin.hero_section.image_path && imagePreview) {
                        imagePreview.src = `/storage/${banners.image_path}`;
                        imagePreview.style.display = 'block';
                    }
                } else {
                    console.error('Failed to fetch Hero Section data:', data);
                }
            })
            .catch(error => {
                console.error('Error fetching Hero Section data:', error);
            });
        });
    });

    // Handle delete button click
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const heroId = this.getAttribute('data-id');
            const heroName = this.getAttribute('data-name');
            
            if (confirm(`Apakah Anda yakin ingin menghapus Hero Section "${heroName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `{{ url('admin.hero_sections') }}/${heroId}`;
                
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
