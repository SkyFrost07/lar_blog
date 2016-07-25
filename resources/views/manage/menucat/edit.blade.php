@extends('layouts.manage')

@section('title', trans('manage.man_menucats'))

@section('page_title', trans('manage.edit'))

@section('content')

<div class="row">
    <div class="col-sm-6">

        {!! show_messes() !!}

        @include('manage.parts.lang_edit_tabs', ['route' => 'menucat.edit'])

        {!! Form::open(['method' => 'put', 'route' => ['menucat.update', $item->id]]) !!}

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text($code.'[name]', ($item_desc) ? $item_desc->name : null, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field($code.'.name') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.slug')}}</label>
            {!! Form::text($code.'[slug]', ($item_desc) ? $item_desc->slug : null, ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
        </div>

        <input type="hidden" name="lang" value="{{$lang}}">
        {!! error_field('lang') !!}

        <a href="{{route('menucat.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>

        {!! Form::close() !!}

    </div>
</div>

@stop

