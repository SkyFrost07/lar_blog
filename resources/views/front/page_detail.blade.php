@extends('layouts.frontend')

@section('title', $page->title)

@section('content')

<h1>{{$page->title}}</h1>

<div>
    <div class="entry_content">
        {!! $page->content !!}
    </div>
</div>

@stop

