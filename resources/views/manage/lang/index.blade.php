@extends('layouts.manage')

@section('title', trans('manage.man_langs'))

@section('page_title', trans('manage.man_langs'))

@section('options')
<li class="{{isActive('lang.index', 1)}}"><a href="{{route('lang.index', ['status' => 1])}}">{{trans('manage.all')}}</a></li>
<li class="{{isActive('lang.index', -1)}}"><a href="{{route('lang.index', ['status' => -1])}}">{{trans('manage.disable')}}</a></li>
@stop

@section('actions')

@if(cando('manage_langs'))
<a href="{{route('lang.create')}}" class="btn btn-sm btn-success navbar-btn"><i class="fa fa-plus"></i> {{trans('manage.create')}}</a>

{!! Form::open(['method' => 'post', 'route' => 'lang.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.restore')]) !!}
{!! Form::hidden('action', 'restore') !!}
<button type="submit" class="btn btn-sm btn-info navbar-btn"><i class="fa fa-mail-forward"></i> {{trans('manage.restore')}}</button>
{!! Form::close() !!}

{!! Form::open(['method' => 'post', 'route' => 'lang.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.remove')]) !!}
{!! Form::hidden('action', 'remove') !!}
<button type="submit" class="btn btn-sm btn-danger navbar-btn"><i class="fa fa-remove"></i> {{trans('manage.remove')}}</button>
{!! Form::close() !!}
@endif

@stop

@section('table_nav')
@include('manage.parts.table_nav')
@stop

@section('content')

{!! show_messes() !!}
@if(!$items->isEmpty())
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th width="30"><input type="checkbox" name="massdel" class="checkall"/></th>
                <th>ID {!! link_order('id') !!}</th>
                <th>{{trans('manage.icon')}}</th>
                <th>{{trans('manage.name')}} {!! link_order('name') !!}</th>
                <th>{{trans('manage.code')}} {!! link_order('code') !!}</th>
                <th>{{trans('manage.folder')}}</th>
                <th>{{trans('manage.unit')}}</th>
                <th>{{trans('manage.ratio_currency')}}</th>
                <th>{{trans('manage.order')}} {!! link_order('order') !!}</th>
                <th>{{trans('manage.status')}} {!! link_order('status') !!}</th>
                <th>{{trans('manage.default')}}</th>
                <th width="135">{{trans('manage.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="checked[]" class="checkitem" value="{{ $item->id }}" /></td>
                <td>{{ $item->id }}</td>
                <td>{!! $item->icon() !!}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->folder }}</td>
                <td>{{ $item->unit }}</td>
                <td>{{ $item->ratio_currency }}</td>
                <td>{{ $item->order }}</td>
                <td>{{ $item->status() }}</td>
                <td>{{ $item->is_default() }}</td>
                <td>
                    <a href="{{route('lang.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
                    
                    {!! Form::open(['method' => 'delete', 'route' => ['lang.destroy', $item->id], 'class' => 'form-inline remove-btn', 'title' => trans('manage.destroy')]) !!}
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop

