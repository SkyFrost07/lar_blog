@extends('layouts.manage')

@section('title', trans('manage.man_tags'))

@section('page_title', trans('manage.man_tags'))

@section('options')
<li class="{{isActive('tag.index')}}"><a href="{{route('tag.index')}}">{{trans('manage.all')}}</a></li>
@stop

@section('actions')

@if(cando('manage_tags'))
<a href="{{route('tag.create')}}" class="btn btn-sm btn-success navbar-btn"><i class="fa fa-plus"></i> {{trans('manage.create')}}</a>
{!! Form::open(['method' => 'post', 'route' => 'tag.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.remove')]) !!}
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
                <th>{{trans('manage.name')}} {!! link_order('pivot_name') !!}</th>
                <th>{{trans('manage.slug')}}</th>
                <th>{{trans('manage.order')}} {!! link_order('order') !!}</th>
                <th>{{trans('manage.count')}} {!! link_order('count') !!}</th>
                <th>{{trans('manage.status')}} {!! link_order('status') !!}</th>
                <th width="135">{{trans('manage.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="checked[]" class="checkitem" value="{{ $item->id }}" /></td>
                <td>{{$item->id}}</td>
                <td>{{$item->pivot->name}}</td>
                <td>{{$item->pivot->slug}}</td>
                <td>{{$item->order}}</td>
                <td>{{$item->count}}</td>
                <td>{{$item->status()}}</td>
                <td>
                    <a href="{{route('tag.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
                    
                    {!! Form::open(['method' => 'delete', 'route' => ['tag.destroy', $item->id], 'class' => 'form-inline remove-btn', 'title' => trans('manage.destroy')]) !!}
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

