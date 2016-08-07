@extends('layouts.manage')

@section('title', trans('manage.man_cats'))

@section('page_title', trans('manage.man_cats'))

@section('options')
<li class="{{isActive('cat.index')}}"><a href="{{route('cat.index')}}">{{trans('manage.all')}}</a></li>
@stop

@section('actions')

@if(cando('manage_cats'))
<a href="{{route('cat.create')}}" class="btn btn-sm btn-success navbar-btn"><i class="fa fa-plus"></i> {{trans('manage.create')}}</a>

{!! Form::open(['method' => 'post', 'route' => 'cat.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.remove')]) !!}
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
                <th>ID {!! link_order('taxs.id') !!}</th>
                <th>{{trans('manage.name')}} {!! link_order('td.name') !!}</th>
                <th>{{trans('manage.slug')}}</th>
                <th>{{trans('manage.parent')}} {!! link_order('parent_id') !!}</th>
                <th>{{trans('manage.order')}} {!! link_order('order') !!}</th>
                <th>{{trans('manage.count')}} {!! link_order('count') !!}</th>
                <th width="93">{{trans('manage.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            {!! $tableCats !!}
        </tbody>
    </table>
</div>
@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop

