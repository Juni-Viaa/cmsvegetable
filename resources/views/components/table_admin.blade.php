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
                        @include('components.modal_edit')

                        <!-- Tombol Delete -->
                        @include('components.modal_delete')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $data->appends(['search' => request('search')])->links() }}
</div>
