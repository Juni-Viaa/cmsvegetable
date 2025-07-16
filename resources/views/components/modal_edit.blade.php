<!-- Modal toggle -->
<button data-modal-target="{{ $modal_id }}-{{ $row->{$id_field} }}" data-modal-toggle="{{ $modal_id }}-{{ $row->{$id_field} }}" data-id="{{ $row->{$id_field} }}" data-name="{{ $row->name ?? 'Item' }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full hover:bg-indigo-800 transition">
    Edit
</button>

<!-- Main modal -->
<div id="{{ $modal_id }}-{{ $row->{$id_field} }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 overflow-y-auto bg-white/80 backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="bg-white shadow-2xl border border-neutral-200" style="width: 480px;">
            <!-- Modal header -->
            <div class="flex items-center justify-between px-8 py-6 border-b border-neutral-100">
                <h3 class="text-xl font-semibold text-neutral-900 tracking-tight">
                    {{ $modal_name }}
                </h3>
                <button data-modal-hide="{{ $modal_id }}-{{ $row->{$id_field} }}" type="button" class="text-neutral-400 hover:text-neutral-700 rounded-full p-2 transition focus:outline-none focus:ring-2 focus:ring-neutral-300">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="{{ str_replace(':id', $row->{$id_field}, $form_action) }}" method="POST" enctype="multipart/form-data" class="px-8 py-6">
                @csrf
                @method('PUT')
                <div class="grid gap-5 mb-6 grid-cols-2">
                    @foreach ($fields as $field)
                        <div class="col-span-2">
                            <label for="{{ $field['name'] }}" class="block mb-2 text-sm font-medium text-neutral-800">
                                {{ $field['label'] }}
                                @if($field['required'] ?? false)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            @switch($field['type'])
                                @case('text')
                                @case('email')
                                @case('number')
                                @case('password')
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ old($field['name'], $row->{$field['name']} ?? '') }}" placeholder="{{ $field['placeholder'] ?? '' }}" class="block w-full rounded-lg border border-neutral-200 bg-neutral-50 focus:bg-white shadow-none focus:border-neutral-400 focus:ring-2 focus:ring-neutral-200 text-sm text-neutral-900 placeholder-neutral-400 @error($field['name']) border-red-400 @enderror transition" {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                @break
                                @case('file')
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" accept="{{ $field['accept'] ?? 'image/*' }}" data-preview="preview-{{ $field['name'] }}" class="block w-full text-sm text-neutral-900 border border-neutral-200 rounded-lg cursor-pointer bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-200 @error($field['name']) border-red-400 @enderror transition" {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                    <!-- Image preview -->
                                    <img id="preview-{{ $field['name'] }}" src="" alt="Preview" class="mt-2 max-w-full h-auto rounded-lg shadow-sm border border-neutral-100" style="display: none; max-height: 200px;">
                                @break
                                @case('textarea')
                                    <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" rows="4" placeholder="{{ $field['placeholder'] ?? '' }}" class="block w-full rounded-lg border border-neutral-200 bg-neutral-50 focus:bg-white shadow-none focus:border-neutral-400 focus:ring-2 focus:ring-neutral-200 text-sm text-neutral-900 placeholder-neutral-400 @error($field['name']) border-red-400 @enderror transition" {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old($field['name'], $row->{$field['name']} ?? '') }}</textarea>
                                @break
                                @case('select')
                                    <select name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="block w-full rounded-lg border border-neutral-200 bg-neutral-50 focus:bg-white shadow-none focus:border-neutral-400 focus:ring-2 focus:ring-neutral-200 text-sm text-neutral-900 @error($field['name']) border-red-400 @enderror transition" {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                        <option value="" {{ !old($field['name'], $row->{$field['name']} ?? '') ? 'selected' : '' }} disabled>
                                            {{ $field['placeholder'] ?? 'Select option' }}
                                        </option>
                                        @if(isset($field['options']) && is_array($field['options']))
                                            @foreach ($field['options'] as $key => $option)
                                                @php
                                                    $selectedValue = old($field['name'], $row->{$field['name']} ?? '');
                                                    $optionValue = is_array($option) ? $option['value'] : $key;
                                                    $optionLabel = is_array($option) ? $option['label'] : $option;
                                                @endphp
                                                <option value="{{ $optionValue }}" {{ $selectedValue == $optionValue ? 'selected' : '' }}>
                                                    {{ $optionLabel }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                @break
                                @case('checkbox')
                                    <div class="flex items-center">
                                        <input type="checkbox" name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ $field['value'] ?? '1' }}" {{ old($field['name'], $row->{$field['name']} ?? false) ? 'checked' : '' }} class="rounded border-neutral-300 text-neutral-700 shadow-sm focus:ring-neutral-400">
                                        <label for="{{ $field['name'] }}" class="ml-2 text-sm font-medium text-neutral-700">
                                            {{ $field['label'] }}
                                        </label>
                                    </div>
                                @break
                                @case('radio')
                                    @if(isset($field['options']) && is_array($field['options']))
                                        @foreach ($field['options'] as $key => $option)
                                            <div class="flex items-center mb-2">
                                                <input type="radio" name="{{ $field['name'] }}" id="{{ $field['name'] }}_{{ $key }}" value="{{ is_array($option) ? $option['value'] : $key }}"{{ old($field['name'], $row->{$field['name']} ?? '') == (is_array($option) ? $option['value'] : $key) ? 'checked' : '' }} class="rounded border-neutral-300 text-neutral-700 shadow-sm focus:ring-neutral-400">
                                                <label for="{{ $field['name'] }}_{{ $key }}" class="ml-2 text-sm font-medium text-neutral-700">
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
                <div class="flex items-center justify-end px-0 py-4 border-t border-neutral-100 rounded-b-2xl">
                    <button type="submit" class="inline-flex items-center px-5 py-3 bg-indigo-700 border border-transparent rounded-full font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-neutral-300 focus:ring-offset-2 transition duration-300">
                        Save
                    </button>
                    <button data-modal-hide="{{ $modal_id }}-{{ $row->{$id_field} }}" type="button" class="inline-flex items-center px-5 py-3 ml-3 bg-white border border-neutral-200 rounded-full font-semibold text-sm text-neutral-700 uppercase tracking-widest hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300 focus:ring-offset-2 transition duration-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
