@extends('layouts.test')

@section('content')

<script src="/plugins/tinymce/tinymce.min.js"></script>

<div class="col-sm-6 col-sm-offset-3">
    <div class="form-group">
        <textarea class="txt_editor form-control" rows="5"></textarea>
    </div>
</div>

<script>
(function($){
    tinymce.init({
        selector: '.txt_editor',
        plugins: 'code ex_loadfile',
        toolbar: 'ex_loadfile image link code'
    });
})(jQuery);
</script>

@stop

