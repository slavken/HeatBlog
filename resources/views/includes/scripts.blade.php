<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script>
    var editor = document.querySelector('#editor');
    ClassicEditor
        .create(editor)
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>