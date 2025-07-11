<form class="inline" method="POST" action="{{ str_replace(':id', $row->{$id_field}, $delete_route) }}">
    @csrf
    @method('DELETE')
    <button type="submit" data-id="{{ $row->{$id_field} }}" data-name="{{ $row->name ?? 'Item' }}"
        class="font-bold py-1 px-2 text-white bg-red-600 rounded-full">Delete</button>
</form>
