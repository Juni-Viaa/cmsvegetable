<form class="inline delete-form" method="POST"
    action="{{ str_replace(':id', $row->{$id_field}, $delete_route) }}">
    @csrf
    @method('DELETE')
    <button type="button"
        class="btn-delete font-bold py-3 px-5 text-white bg-red-600 rounded-full"
        data-id="{{ $row->{$id_field} }}"
        data-name="{{ $row->name ?? 'Item' }}">
        Delete
    </button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                const name = this.dataset.name || 'item ini';
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: `Data "${name}" akan dihapus!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
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