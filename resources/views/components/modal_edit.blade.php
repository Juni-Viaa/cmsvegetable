<form action="{{ str_replace(':id', $row->{ $id_field }, $form_action) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="p-4 md:p-5 grid gap-4 mb-4 grid-cols-2">
        @foreach ($fields as $field)
            <div class="col-span-2">
                <label for="{{ $field['name'] }}" class="block mb-2 text-sm font-medium text-gray-900">{{ $field['label'] }}</label>
                @switch($field['type'])
                                @case('text')
                                @case('email')
                                @case('number')
                                @case('password')
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" value="{{ old($field['name'], $field['value'] ?? '') }}" class="bg-[#F5F5F5] border border-gray-300 text-black placeholder-black text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 @error($field['name']) border-red-500 @enderror" {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                @break
                                
                                @case('file')
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" accept="{{ $field['accept'] ?? 'image/*' }}" data-preview="preview-{{ $field['name'] }}" class="block w-full text-sm text-black border border-gray-300 rounded-lg cursor-pointer bg-[#F5F5F5] focus:outline-none @error($field['name']) border-red-500 @enderror" {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                    
                                    <!-- Image preview -->
                                    <img id="preview-{{ $field['name'] }}" src="" alt="Preview" class="mt-2 max-w-full h-auto rounded-lg shadow-sm" style="display: none; max-height: 200px;">
                                @break

                                @case('textarea')
                                    <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" rows="{{ $field['rows'] ?? 4 }}" placeholder="{{ $field['placeholder'] ?? '' }}" class="block p-2.5 w-full text-sm text-black placeholder-black bg-[#F5F5F5] rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 @error($field['name']) border-red-500 @enderror" {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ old($field['name'], $field['value'] ?? '') }}</textarea>
                                @break

                                @case('select')
                                    <select name="{{ $field['name'] }}" id="{{ $field['name'] }}" class="bg-[#F5F5F5] placeholder-black border border-gray-300 text-black text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 @error($field['name']) border-red-500 @enderror" {{ ($field['required'] ?? false) ? 'required' : '' }}>
                                        <option value="" {{ !old($field['name'], $field['value'] ?? '') ? 'selected' : '' }} disabled>
                                            {{ $field['placeholder'] ?? 'Select option' }}
                                        </option>
                                        @if(isset($field['options']) && is_array($field['options']))
                                            @foreach ($field['options'] as $key => $option)
                                                @if(is_array($option))
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
                                        <input type="checkbox" name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ $field['value'] ?? '1' }}" {{ old($field['name'], $field['checked'] ?? false) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <label for="{{ $field['name'] }}" class="ml-2 text-sm font-medium text-gray-900">
                                            {{ $field['label'] }}
                                        </label>
                                    </div>
                                @break

                                @case('radio')
                                    @if(isset($field['options']) && is_array($field['options']))
                                        @foreach ($field['options'] as $key => $option)
                                            <div class="flex items-center mb-2">
                                                <input type="radio" name="{{ $field['name'] }}" id="{{ $field['name'] }}_{{ $key }}" value="{{ is_array($option) ? $option['value'] : $key }}"{{ old($field['name'], $field['value'] ?? '') == (is_array($option) ? $option['value'] : $key) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                                <label for="{{ $field['name'] }}_{{ $key }}" class="ml-2 text-sm font-medium text-gray-900">
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
    <div
        class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Save
        </button>
        <button data-modal-hide="{{ $modal_id }}-{{ $row->{ $id_field } }}" type="button"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
            Cancel
        </button>
    </div>
</form>