<div class="mt-6 relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="table-auto w-full text-sm text-left text-gray-500">
        @if (count($data) > 0)
            <thead class="text-xs text-black uppercase bg-[#2E7D32]">
                <tr>
                    <th class="px-6 py-3">No</th>
                    @foreach ($columns as $key => $label)
                        <th class="px-6 py-3">{{ $label }}</th>
                    @endforeach
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
        @endif
        <tbody>
            @foreach ($data as $row)
                <tr class="odd:bg-[#A2D77C] even:bg-white">
                    <td class="px-6 py-4 text-black">{{ $loop->iteration }}</td>
                    @foreach ($columns as $key => $label)
                        <td class="px-6 py-4 text-black">
                            @if ($key === 'image_path' && $row->$key)
                                <img src="{{ asset('storage/' . $row->$key) }}" alt="Image" class="w-12 h-12 object-cover rounded">
                            @elseif ($key === 'created_at' || $key === 'updated_at')
                                {{ $row->$key ? $row->$key->format('Y-m-d H:i') : '-' }}
                            @else
                                {{ $row->$key ?? '-' }}
                            @endif
                        </td>
                    @endforeach
                    <td class="px-6 py-4 space-x-2">
                        <!-- Tombol Edit -->
                        <button data-modal-target="{{ $modal_id }}-{{ $row->{ $id_field } }}" data-modal-toggle="{{ $modal_id }}-{{ $row->{ $id_field } }}" data-id="{{ $row->{ $id_field } }}" data-name="{{ $row->name ?? 'Item' }}" class="text-blue-600 hover:underline">Edit</button>

                        <!-- Tombol Delete -->
                        @include('components.modal_delete')
                    </td>
                </tr>

                <!-- Modal Edit Per-Baris -->
                <div id="{{ $modal_id }}-{{ $row->{ $id_field } }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow-sm">
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ $modal_name }}
                                </h3>
                                <button data-modal-hide="{{ $modal_id }}-{{ $row->{ $id_field } }}" type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            @include('components.modal_edit')
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
    {{ $data->appends(['search' => request('search')])->links() }}
</div>
