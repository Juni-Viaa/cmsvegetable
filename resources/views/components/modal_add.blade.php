<!-- Modal toggle -->
<button data-modal-target="{{ $modal_id }}" data-modal-toggle="{{ $modal_id }}" type="button"
    class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full hover:bg-indigo-800 transition">
    {{ $modal }}
</button>

<!-- Main modal -->
<div id="{{ $modal_id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4 pt-80">
    <div class="relative bg-white rounded-lg shadow max-w-2xl w-full">
        <div class="relative bg-white rounded-lg shadow-sm">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-black">
                    {{ $modal_name }}
                </h3>
                <button data-modal-hide="{{ $modal_id }}" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal body with form -->
            <form action="{{ $form_action }}" method="{{ $form_method === 'GET' ? 'GET' : 'POST' }}"
                enctype="multipart/form-data" class="p-4 md:p-5">
                @csrf
                @if ($form_method !== 'GET' && $form_method !== 'POST')
                    @method($form_method)
                @endif

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
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        value="{{ old($field['name'], $field['value'] ?? '') }}"
                                        class="bg-[#F5F5F5] border border-gray-300 text-black placeholder-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error($field['name']) border-red-500 @enderror"
                                        {{ $field['required'] ?? false ? 'required' : '' }}>
                                @break

                                @case('file')
                                    @php
                                        $prefix = $mode ?? 'add';
                                    @endphp
                                    <div x-data="{
                                        fileName_{{ $prefix }}: '',
                                        fileChosen_{{ $prefix }}: false,
                                        handleDrop_{{ $prefix }}(event) {
                                            const files = event.dataTransfer.files;
                                            if (files.length > 0) {
                                                const input = this.$refs.fileInput_{{ $prefix }};
                                                input.files = files;
                                                this.fileName_{{ $prefix }} = files[0].name;
                                                this.fileChosen_{{ $prefix }} = true;
                                            }
                                        },
                                        clearFile_{{ $prefix }}() {
                                            this.fileName_{{ $prefix }} = '';
                                            this.fileChosen_{{ $prefix }} = false;
                                            this.$refs.fileInput_{{ $prefix }}.value = null;
                                        }
                                    }" class="flex items-center justify-center w-full"
                                        @dragover.prevent @drop.prevent="handleDrop_{{ $prefix }}($event)">

                                        <!-- DRAG & DROP -->
                                        <label x-show="!fileChosen_{{ $prefix }}" for="{{ $prefix }}_{{ $field['name'] }}"
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
                                        <input x-ref="fileInput_{{ $prefix }}" type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                            id="{{ $prefix }}_{{ $field['name'] }}" accept="{{ $field['accept'] ?? 'image/*' }}"
                                            class="hidden"
                                            @change="if ($event.target.files.length > 0) { fileName_{{ $prefix }} = $event.target.files[0].name; fileChosen_{{ $prefix }} = true }" />

                                        <!-- FILE SELECTED VIEW -->
                                        <div x-show="fileChosen_{{ $prefix }}"
                                            class="flex items-center justify-between w-full px-4 py-3 bg-gray-100 rounded-lg space-x-2">
                                            <span class="text-sm text-gray-700 truncate max-w-[70%]" x-text="fileName_{{ $prefix }}"></span>
                                            <!-- HAPUS -->
                                            <button type="button" @click="clearFile_{{ $prefix }}()"
                                                class="text-sm text-red-500 hover:text-red-700" title="Hapus file">
                                                ❌
                                            </button>
                                        </div>
                                    </div>
                                @break

                                @case('textarea')
                                    <label for="{{ $field['name'] }}" class="block mb-2 font-medium text-gray-700"></label>
                                    <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" rows="{{ $field['rows'] ?? 4 }}"
                                        class="w-full border border-gray-300 rounded p-2"></textarea>
                                    <script>
                                        tinymce.init({
                                            selector: '#{{ $field['name'] }}',
                                            menubar: false,
                                            plugins: 'lists link image code',
                                            toolbar: 'undo redo | styles | bold italic underline | bullist numlist | link image | code',
                                            height: 300
                                        });
                                    </script>
                                @break

                                @case('select')
                                    <select name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                        class="bg-[#F5F5F5] placeholder-black border border-gray-300 text-black text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 @error($field['name']) border-red-500 @enderror"
                                        {{ $field['required'] ?? false ? 'required' : '' }}>
                                        <option value=""
                                            {{ !old($field['name'], $field['value'] ?? '') ? 'selected' : '' }} disabled>
                                            {{ $field['placeholder'] ?? 'Select option' }}
                                        </option>
                                        @if (isset($field['options']) && is_array($field['options']))
                                            @foreach ($field['options'] as $key => $option)
                                                @if (is_array($option))
                                                    <option value="{{ $option['value'] }}"
                                                        {{ old($field['name'], $field['value'] ?? '') == $option['value'] ? 'selected' : '' }}>
                                                        {{ $option['label'] }}
                                                    </option>
                                                @else
                                                    <option value="{{ $key }}"
                                                        {{ old($field['name'], $field['value'] ?? '') == $key ? 'selected' : '' }}>
                                                        {{ $option }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                @break

                                @case('checkbox')
                                    <div class="flex items-center">
                                        <input type="checkbox" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                            value="{{ $field['value'] ?? '1' }}"
                                            {{ old($field['name'], $field['checked'] ?? false) ? 'checked' : '' }}
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <label for="{{ $field['name'] }}" class="ml-2 text-sm font-medium text-gray-900">
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
                                                    value="{{ is_array($option) ? $option['value'] : $key }}"{{ old($field['name'], $field['value'] ?? '') == (is_array($option) ? $option['value'] : $key) ? 'checked' : '' }}
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                                <label for="{{ $field['name'] }}_{{ $key }}"
                                                    class="ml-2 text-sm font-medium text-gray-900">
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

                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit"
                        class="px-5 py-2.5 text-sm text-center text-white bg-indigo-700 hover:bg-indigo-800 hover:text-gray-300 focus:outline-none font-medium rounded-lg focus:z-10 ">
                        {{ $submit_text ?? 'Save' }}
                    </button>
                    <button data-modal-hide="{{ $modal_id }}" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-white focus:outline-none bg-red-600 rounded-lg hover:bg-red-700 hover:text-gray-300 focus:z-10">
                        {{ $cancel_text ?? 'Cancel' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
