<!-- Modal toggle -->
<button data-modal-target="{{ $modal_id }}-{{ $row->{$id_field} }}"
    data-modal-toggle="{{ $modal_id }}-{{ $row->{$id_field} }}" data-id="{{ $row->{$id_field} }}"
    data-name="{{ $row->name ?? 'Item' }}"
    class="font-bold py-1 px-2 bg-indigo-700 text-white rounded-full hover:bg-indigo-800 transition">
    Edit
</button>

<!-- Main modal -->
<div id="{{ $modal_id }}-{{ $row->{$id_field} }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4 pt-80">
    <div class="relative bg-white rounded-lg shadow max-w-2xl w-full">
        <div class="relative bg-white rounded-lg shadow-sm">
            <!-- Modal header -->
            <div class="flex items-center justify-between px-8 py-6 border-b border-neutral-100">
                <h3 class="text-xl font-semibold text-neutral-900 tracking-tight">
                    {{ $modal_name }}
                </h3>
                <button data-modal-hide="{{ $modal_id }}-{{ $row->{$id_field} }}" type="button"
                    class="text-neutral-400 hover:text-neutral-700 rounded-full p-2 transition focus:outline-none focus:ring-2 focus:ring-neutral-300">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="{{ str_replace(':id', $row->{$id_field}, $form_action) }}" method="POST"
                enctype="multipart/form-data" class="px-8 py-6">
                @csrf
                @method('PUT')
                <div class="grid gap-5 mb-6 grid-cols-2">
                    @foreach ($fields as $field)
                        <div class="col-span-2">
                            <label for="{{ $field['name'] }}" class="block mb-2 text-sm font-medium text-neutral-800">
                                {{ $field['label'] }}
                                @if ($field['required'] ?? false)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            @switch($field['type'])
                                @case('text')
                                @case('email')

                                @case('number')
                                @case('password')
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                        value="{{ old($field['name'], $row->{$field['name']} ?? '') }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        class="block w-full rounded-lg border border-neutral-200 bg-neutral-50 focus:bg-white shadow-none focus:border-neutral-400 focus:ring-2 focus:ring-neutral-200 text-sm text-neutral-900 placeholder-neutral-400 @error($field['name']) border-red-400 @enderror transition"
                                        {{ $field['required'] ?? false ? 'required' : '' }}>
                                @break

                                @case('file')
                                    @php
                                        $prefix = $mode ?? 'edit';
                                        $uniqueId = $uniqueId ?? uniqid();
                                    @endphp

                                    <div x-data="fileUploadComponent('{{ $prefix }}', '{{ $uniqueId }}')" class="flex items-center justify-center w-full"
                                        @dragover.prevent @drop.prevent="handleDrop($event)">

                                        <!-- DRAG & DROP -->
                                        <label x-show="!fileChosen"
                                            for="{{ $prefix }}_{{ $field['name'] }}_{{ $uniqueId }}"
                                            class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"
                                                    aria-hidden="true">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                                </p>
                                            </div>
                                        </label>

                                        <!-- FILE INPUT (HIDDEN) -->
                                        <input x-ref="fileInput" type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                            id="{{ $prefix }}_{{ $field['name'] }}_{{ $uniqueId }}"
                                            accept="{{ $field['accept'] ?? 'image/*' }}" class="hidden"
                                            @change="if ($event.target.files.length > 0) { 
                                                fileName = $event.target.files[0].name; 
                                                fileChosen = true 
                                            }" />

                                        <!-- FILE SELECTED VIEW -->
                                        <div x-show="fileChosen"
                                            class="flex items-center justify-between w-full px-4 py-3 bg-gray-100 rounded-lg space-x-2">
                                            <span class="text-sm text-gray-700 truncate max-w-[70%]" x-text="fileName"></span>
                                            <!-- HAPUS -->
                                            <button type="button" @click="clearFile()"
                                                class="text-sm text-red-500 hover:text-red-700" title="Hapus file">
                                                ❌
                                            </button>
                                        </div>
                                    </div>

                                    <script>
                                        function fileUploadComponent(prefix, uniqueId) {
                                            return {
                                                fileName: '',
                                                fileChosen: false,
                                                prefix: prefix,
                                                uniqueId: uniqueId,
                                                handleDrop(event) {
                                                    const files = event.dataTransfer.files;
                                                    if (files.length > 0) {
                                                        const input = this.$refs.fileInput;
                                                        input.files = files;
                                                        this.fileName = files[0].name;
                                                        this.fileChosen = true;
                                                    }
                                                },
                                                clearFile() {
                                                    this.fileName = '';
                                                    this.fileChosen = false;
                                                    this.$refs.fileInput.value = null;
                                                }
                                            }
                                        }
                                    </script>
                                @break

                                @case('textarea')
                                    <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" rows="4"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        class="block w-full rounded-lg border border-neutral-200 bg-neutral-50 focus:bg-white shadow-none focus:border-neutral-400 focus:ring-2 focus:ring-neutral-200 text-sm text-neutral-900 placeholder-neutral-400 @error($field['name']) border-red-400 @enderror transition"
                                        {{ $field['required'] ?? false ? 'required' : '' }}>{{ old($field['name'], $row->{$field['name']} ?? '') }}</textarea>
                                @break

                                @case('select')
                                    <select name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                        class="block w-full rounded-lg border border-neutral-200 bg-neutral-50 focus:bg-white shadow-none focus:border-neutral-400 focus:ring-2 focus:ring-neutral-200 text-sm text-neutral-900 @error($field['name']) border-red-400 @enderror transition"
                                        {{ $field['required'] ?? false ? 'required' : '' }}>
                                        <option value=""
                                            {{ !old($field['name'], $row->{$field['name']} ?? '') ? 'selected' : '' }}
                                            disabled>
                                            {{ $field['placeholder'] ?? 'Select option' }}
                                        </option>
                                        @if (isset($field['options']) && is_array($field['options']))
                                            @foreach ($field['options'] as $key => $option)
                                                @php
                                                    $selectedValue = old($field['name'], $row->{$field['name']} ?? '');
                                                    $optionValue = is_array($option) ? $option['value'] : $key;
                                                    $optionLabel = is_array($option) ? $option['label'] : $option;
                                                @endphp
                                                <option value="{{ $optionValue }}"
                                                    {{ $selectedValue == $optionValue ? 'selected' : '' }}>
                                                    {{ $optionLabel }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                @break

                                @case('checkbox')
                                    <div class="flex items-center">
                                        <input type="checkbox" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                            value="{{ $field['value'] ?? '1' }}"
                                            {{ old($field['name'], $row->{$field['name']} ?? false) ? 'checked' : '' }}
                                            class="rounded border-neutral-300 text-neutral-700 shadow-sm focus:ring-neutral-400">
                                        <label for="{{ $field['name'] }}" class="ml-2 text-sm font-medium text-neutral-700">
                                            {{ $field['label'] }}
                                        </label>
                                    </div>
                                @break

                                @case('radio')
                                    @if (isset($field['options']) && is_array($field['options']))
                                        @foreach ($field['options'] as $key => $option)
                                            <div class="flex items-center mb-2">
                                                <input type="radio" name="{{ $field['name'] }}"
                                                    id="{{ $field['name'] }}_{{ $key }}"
                                                    value="{{ is_array($option) ? $option['value'] : $key }}"{{ old($field['name'], $row->{$field['name']} ?? '') == (is_array($option) ? $option['value'] : $key) ? 'checked' : '' }}
                                                    class="rounded border-neutral-300 text-neutral-700 shadow-sm focus:ring-neutral-400">
                                                <label for="{{ $field['name'] }}_{{ $key }}"
                                                    class="ml-2 text-sm font-medium text-neutral-700">
                                                    {{ is_array($option) ? $option['label'] : $option }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                @break
                            @endswitch
                            @error($field['name'])
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm text-center text-white bg-indigo-700 hover:bg-indigo-800 hover:text-gray-300 focus:outline-none font-medium rounded-lg focus:z-10 ">
                        {{ $submit_text ?? 'Save' }}
                    </button>
                    <button data-modal-hide="{{ $modal_id }}-{{ $row->{$id_field} }}" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-white focus:outline-none bg-red-600 rounded-lg hover:bg-red-700 hover:text-gray-300 focus:z-10">
                        {{ $cancel_text ?? 'Cancel' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                const name = this.dataset.name || 'item ini';
                Swal.fire({
                    title: 'Simpan perubahan?',
                    text: `Perubahan "${name}" akan disimpan!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
