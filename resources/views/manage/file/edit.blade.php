@extends('layouts.manage')

@section('title', trans('manage.man_roles'))

@section('page_title', trans('manage.edit'))

@section('content')

{!! show_messes() !!}

@if($item)
{!! Form::open(['method' => 'put', 'route' => ['role.update', $item->id]]) !!}

<div class="row">
    <div class="col-sm-6">

        <div class="form-group">
            <label>{{trans('manage.name')}}</label>
            {!! Form::text('name', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('name') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.url')}} (*)</label>
            {!! Form::text('url', $item->name, ['class' => 'form-control', 'placeholder' => trans('manage.url')]) !!}
            {!! error_field('url') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.type')}} (*)</label>
            {!! Form::text('type', $item->type, ['class' => 'form-control', 'placeholder' => trans('manage.type')]) !!}
            {!! error_field('type') !!}
        </div>

        @if(cando('manage_files'))
        <div class="form-group">
            <label>{{trans('manage.author')}}</label>
            {!! Form::select('author_id', [], $item->author_id, ['class' => 'form-control']) !!}
        </div>
        @endif

        <a href="{{route('role.index')}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>

    </div>
    
    <div class="col-sm-6">
        
        <div class="form-group">
            <label>{{trans('manage.thumbnail')}}</label>
            <div>
                {!! $itme->getImage('full') !!}
            </div>
        </div>
        
    </div>
</div>
{!! Form::close() !!}
@else
<p class="alert alert-danger">{{trans('manage.no_item')}}</p>
@endif

@stop


