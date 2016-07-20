@extends('layouts.manage')

@section('title', trans('manage.man_posts'))

@section('page_title', trans('manage.edit'))

@section('content')

{!! show_messes() !!}

@if($item)
{!! Form::open(['method' => 'put', 'route' => ['post.update', $item->id]]) !!}

<div class="row">
    <div class="col-sm-8">

        <?php $langs = get_langs(); ?>
        <ul class="nav nav-tabs">
            @foreach($langs as $lang)
            <li class="{{ localActive($lang->code) }}"><a href="#tab-{{$lang->code}}" data-toggle="tab">{{$lang->name}}</a></li>
            @endforeach
        </ul>
        <br />

        <div class="tab-content">
            @foreach($langs as $lang)
            <?php
            $code = $lang->code;
            $item_desc = $lang->post_pivot($item->id);
            ?>
            <div class="tab-pane {{ localActive($code) }}" id="tab-{{$lang->code}}">

                <div class="form-group">
                    <label>{{trans('manage.name')}} (*)</label>
                    {!! Form::text($code.'[title]', $item_desc ? $item_desc->title : old($code.'[title]'), ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
                    {!! error_field($code.'.title') !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.slug')}}</label>
                    {!! Form::text($code.'[slug]', $item_desc ? $item_desc->slug : old($code.'[slug]'), ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.content')}}</label>
                    {!! Form::textarea($code.'[content]', $item_desc ? $item_desc->content : old($code.'[content]'), ['class' => 'form-control editor_content', 'rows' => 15, 'placeholder' => trans('manage.content')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.excerpt')}}</label>
                    {!! Form::textarea($code.'[excerpt]', $item_desc ? $item_desc->excerpt : old($code.'[excerpt]'), ['class' => 'form-control editor_excerpt', 'rows' => 5, 'placeholder' => trans('manage.excerpt')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.meta_keyword')}}</label>
                    {!! Form::text($code.'[meta_keyword]', $item_desc ? $item_desc->meta_keyword : old($code.'[meta_keyword]'), ['class' => 'form-control', 'placeholder' => trans('manage.meta_keyword')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.meta_desc')}}</label>
                    {!! Form::textarea($code.'[meta_desc]', $item_desc ? $item_desc->meta_desc : old($code.'[meta_desc]'), ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.meta_desc')]) !!}
                </div>

            </div>
            @endforeach
        </div>

    </div>
    <div class="col-sm-4">

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Trash'], $item->status, ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.category')}}</label>
            <select name="cat_ids[]" multiple class="form-control">
                {!! nested_option($cats, $curr_cats, 0, 0) !!}
            </select>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.category')}}</label>
            <select name="tag_ids[]" multiple class="form-control">
                @foreach($tags as $tag)
                <option value="{{$tag->id}}" {{$selected = in_array($tag->id, $curr_tags) ? 'selected' : ''}} >{{$tag->pivot->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>{{trans('manage.comment_status')}}</label>
            {!! Form::select('status', [1 => 'Open', 0 => 'Close'], $item->comment_status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.views')}}</label>
            {!! Form::number('views', $item->views, ['class' => 'form-control']) !!}
        </div>

        <a href="{{route('post.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>

    </div>
</div>

{!! Form::close() !!}
@else
<p class="alert alert-danger">{{trans('manage.no_item')}}</p>
@endif

@stop

