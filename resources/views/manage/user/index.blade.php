@extends('layouts.manage')

@section('title', trans('manage.man_users'))

@section('page_title', trans('manage.man_users'))

@section('options')
<li class="{{isActive('user.index', 1)}}"><a href="{{route('user.index', ['status' => 1])}}">{{trans('manage.all')}}</a></li>
<li class="{{isActive('user.index', 0)}}"><a href="{{route('user.index', ['status' => 0])}}">{{trans('manage.ban')}}</a></li>
<li class="{{isActive('user.index', -1)}}"><a href="{{route('user.index', ['status' => -1])}}">{{trans('manage.disable')}}</a></li>
@stop

@section('actions')

@if(cando('publish_users'))
<a href="{{route('user.create')}}" class="btn btn-sm btn-success navbar-btn"><i class="fa fa-plus"></i> {{trans('manage.create')}}</a>
@endif
@if(cando('edit_other_users'))
{!! Form::open(['method' => 'post', 'route' => 'user.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.restore')]) !!}
{!! Form::hidden('action', 'restore') !!}
<button type="submit" class="btn btn-sm btn-info navbar-btn"><i class="fa fa-mail-forward"></i> {{trans('manage.restore')}}</button>
{!! Form::close() !!}

{!! Form::open(['method' => 'post', 'route' => 'user.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.ban')]) !!}
{!! Form::hidden('action', 'ban') !!}
<button type="submit" class="btn btn-sm btn-warning navbar-btn"><i class="fa fa-ban"></i> {{trans('manage.ban')}}</button>
{!! Form::close() !!}

{!! Form::open(['method' => 'post', 'route' => 'user.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.disable')]) !!}
{!! Form::hidden('action', 'disable') !!}
<button type="submit" class="btn btn-sm btn-default navbar-btn"><i class="fa fa-power-off"></i> {{trans('manage.disable')}}</button>
{!! Form::close() !!}
@endif
@if(cando('remove_other_users'))
{!! Form::open(['method' => 'post', 'route' => 'user.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.remove')]) !!}
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
                <th>{{trans('manage.name')}} {!! link_order('name') !!}</th>
                <th>{{trans('manage.email')}} {!! link_order('email') !!}</th>
                <th>{{trans('manage.password')}}</th>
                <th>{{trans('manage.role')}} {!! link_order('role_id') !!}</th>
                <th>{{trans('manage.status')}} {!! link_order('status') !!}</th>
                <th width="135">{{trans('manage.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="checked[]" class="checkitem" value="{{ $item->id }}" /></td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>*************</td>
                <td>{{ $item->role->label }}</td>
                <td>{{ $item->status() }}</td>
                <td>
                    @if(cando('edit_my_user', $item->id))
                    <a href="{{route('user.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
                    @endif
                    @if(cando('remove_my_user', $item->id))
                    {!! Form::open(['method' => 'delete', 'route' => ['user.destroy', $item->id], 'class' => 'form-inline remove-btn', 'title' => trans('manage.destroy')]) !!}
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    {!! Form::close() !!}
                    @endif
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

