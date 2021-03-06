@extends('layouts.manage')

@section('title', trans('manage.man_roles'))

@section('page_title', trans('manage.man_roles'))

@section('options')
<li class="{{isActive('role.index')}}"><a href="{{route('role.index')}}">{{trans('manage.all')}}</a></li>
@stop

@section('actions')
<a href="{{route('role.create')}}" class="btn btn-sm btn-success navbar-btn"><i class="fa fa-plus"></i> {{trans('manage.create')}}</a>
{!! Form::open(['method' => 'post', 'route' => 'role.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.remove')]) !!}
{!! Form::hidden('action', 'remove') !!}
<div class="hidden select_items"></div>
<button type="submit" class="btn btn-sm btn-danger navbar-btn"><i class="fa fa-remove"></i> {{trans('manage.remove')}}</button>
{!! Form::close() !!}
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
                <th>{{trans('manage.name')}} {!! link_order('name') !!}</th>
                <th>{{trans('manage.description')}}</th>
                <th>{{trans('manage.default')}}</th>
                <th width="93">{{trans('manage.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="checked[]" class="checkitem" value="{{ $item->id }}" /></td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->label }}</td>
                <td>{{ $item->str_default() }}</td>
                <td>
                    <a href="{{route('role.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
                    
                    {!! Form::open(['method' => 'delete', 'route' => ['role.destroy', $item->id], 'class' => 'form-inline remove-btn', 'title' => trans('manage.remove')]) !!}
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

