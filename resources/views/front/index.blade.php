@extends('layouts.frontend')

@section('title', trans('global.home'))

@section('content')

<h1>{{trans('global.home')}}</h1>

<div>
    <ul>
    @foreach($cats as $cat)
    <li><a href="{{route('cat.view', ['id' => $cat->id, 'slug' => $cat->slug])}}">{{$cat->name}}</a></li>
    @endforeach
    </ul>
</div>
<br />

@stop

