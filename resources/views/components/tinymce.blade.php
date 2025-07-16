<script>
    tinymce.init({
        selector: '{{ $field['name'] }}',
        menubar: false,
        plugins: 'lists link image code',
        toolbar: 'undo redo | styles | bold italic underline | bullist numlist | link image | code',
        height: 300
    });
</script>
