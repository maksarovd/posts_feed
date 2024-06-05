<div>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists preview',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | link image | preview'
        });
    </script>
</div>