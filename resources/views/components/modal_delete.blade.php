<form class="inline" method="POST" action="{{ str_replace(':id', $row->{$id_field}, $delete_route) }}">
    @csrf
    @method('DELETE')
    <button type="submit" data-id="{{ $row->{$id_field} }}" data-name="{{ $row->name ?? 'Item' }}"
        class="font-bold py-4 px-5 bg-red-700 text-white rounded-full">Delete</button>
</form>
