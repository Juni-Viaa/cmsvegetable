<!-- Modal toggle -->
<button data-modal-target="{{ $modal_id }}-{{ $row->{$id_field} }}" data-modal-toggle="{{ $modal_id }}-{{ $row->{$id_field} }}" data-id="{{ $row->{$id_field} }}" data-name="{{ $row->name ?? 'Item' }}" class="text-blue-600 hover:underline">Edit</button>

<!-- Modal Edit Per-Baris -->
<div id="{{ $modal_id }}-{{ $row->{$id_field} }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-[#A2D77C] rounded-lg shadow-sm">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#2E7D32]">
                <h3 class="text-lg font-semibold text-white">
                    {{ $modal_name }}
                </h3>
                <button data-modal-hide="{{ $modal_id }}-{{ $row->{$id_field} }}" type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="{{ str_replace(':id', $row->{$id_field}, $form_action) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-4 md:p-5 grid gap-4 mb-4 grid-cols-2">
                    @foreach ($fields as $field)
                        <div class="col-span-2">
                            <label for="{{ $field['name'] }}"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field['label'] }}</label>
                            @switch($field['type'])
                                @case('text')
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                        value="{{ old($field['name'], $row->{$field['name']} ?? '') }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        class="bg-[#F5F5F5] border border-gray-300 text-black placeholder-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        {{ $field['required'] ?? false ? 'required' : '' }}>
                                @break

                                @case('file')
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        accept="{{ $field['accept'] ?? 'image/*' }}"
                                        data-preview="preview-{{ $field['name'] }}"
                                        class="block w-full text-sm text-black border border-gray-300 rounded-lg cursor-pointer bg-[#F5F5F5] focus:outline-none"
                                        {{ $field['required'] ?? false ? 'required' : '' }}>
                                    <!-- Image preview -->
                                    <img id="preview-{{ $field['name'] }}" src="" alt="Preview"
                                        class="mt-2 max-w-full h-auto rounded-lg shadow-sm"
                                        style="display: none; max-height: 200px;">
                                @break

                                @case('textarea')
                                    <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" rows="4"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        class="block p-2.5 w-full text-sm text-black placeholder-black bg-[#F5F5F5] rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old($field['name'], $row->{$field['name']} ?? '') }}</textarea>
                                @break

                                @case('select')
                                    <select name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                        class="bg-[#F5F5F5] placeholder-black border border-gray-300 text-black text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
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
                            @endswitch
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Save
                    </button>
                    <button data-modal-hide="{{ $modal_id }}-{{ $row->{$id_field} }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-white focus:outline-none bg-[#A1887F] rounded-lg border border-[#A1887F] hover:bg-[#7A625A] hover:text-white focus:z-10 focus:ring-4 focus:ring-[#A1887F]">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
