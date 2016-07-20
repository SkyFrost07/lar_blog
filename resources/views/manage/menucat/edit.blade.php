@extends('layouts.manage')

@section('title', trans('manage.man_menucats'))

@section('page_title', trans('manage.edit'))

@section('content')

<div class="row">
    <div class="col-sm-6">

        {!! show_messes() !!}

        @if($item)
        {!! Form::open(['method' => 'put', 'route' => ['menucat.update', $item->id]]) !!}

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
            $item_desc = $lang->menucat_pivot($item->id);
            ?>
            <div class="tab-pane {{ localActive($code) }}" id="tab-{{$lang->code}}">

                <div class="form-group">
                    <label>{{trans('manage.name')}} (*)</label>
                    {!! Form::text($code.'[name]', ($item_desc) ? $item_desc->name : null, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
                    {!! error_field($code.'.name') !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.slug')}}</label>
                    {!! Form::text($code.'[slug]', ($item_desc) ? $item_desc->slug : null, ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
                </div>

            </div>
            @endforeach
        </div>

        <a href="{{route('menucat.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>

        {!! Form::close() !!}
        @else
        <p class="alert alert-danger">{{trans('manage.no_item')}}</p>
        @endif
    </div>
</div>

@stop

