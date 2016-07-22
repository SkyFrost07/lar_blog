@extends('layouts.test')

@section('content')

<h1>Files</h1>

{!! Form::open(['method' => 'post', 'url' => '/vi/test/upload', 'files' => true]) !!}

<div class="form-group">
    <input type="file" name="files[]" multiple>
</div>

<div class="form-group">
    <button>Submit</button>
</div>

{!! Form::close() !!}

@stop
