@extends('layouts.frontend')

@section('title', $post->title)

@section('content')

<h1>{{$post->title}}</h1>

<p>{{$post->author->name}} | {{$post->created_at->format('d/m/Y')}}</p>
<div>
    <div class="entry_content">
        {!! $post->content !!}
    </div>
    <br />
    <div class="post_cats">
        <h3>Category</h3>
        @if($post->cats)
        <ul>
            @foreach($post->cats as $cat)
            <li><a href="{{route('cat.view', ['id' => $cat->id, 'slug' => $cat->slug])}}">{{$cat->name}}</a></li>
            @endforeach
        </ul>
        @endif
    </div>
    <div class="post_tags">
        <h3>Tags</h3>
        @if($post->tags)
        <ul>
            @foreach($post->tags as $tag)
            <li><a href="{{route('tag.view', ['id' => $tag->id, 'slug' => $tag->slug])}}">{{$tag->name}}</a></li>
            @endforeach
        </ul>
        @endif
    </div>
</div>

@stop

