@extends('layouts.manage')

@section('title', trans('manage.man_pages'))

@section('page_title', trans('manage.man_pages'))

@section('options')
<li class="{{isActive('page.index', 1)}}"><a href="{{route('page.index', ['status' => 1])}}">{{trans('manage.all')}}</a></li>
<li class="{{isActive('page.index', 0)}}"><a href="{{route('page.index', ['status' => 0])}}">{{trans('manage.trash')}}</a></li>
@stop

@section('actions')

@if(cando('publish_posts'))
<a href="{{route('page.create')}}" class="btn btn-sm btn-success navbar-btn"><i class="fa fa-plus"></i> {{trans('manage.create')}}</a>
@endif

@if(cando('manage_posts'))
{!! Form::open(['method' => 'page', 'route' => 'page.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.restore')]) !!}
{!! Form::hidden('action', 'restore') !!}
<button type="submit" class="btn btn-sm btn-info navbar-btn"><i class="fa fa-mail-forward"></i> {{trans('manage.restore')}}</button>
{!! Form::close() !!}

{!! Form::open(['method' => 'page', 'route' => 'page.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.remove')]) !!}
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
                <th>{{trans('manage.name')}} {!! link_order('pt.name') !!}</th>
                <th>{{trans('manage.slug')}}</th>
                <th>{{trans('manage.comment_count')}} {!! link_order('comment_count') !!}</th>
                <th>{{trans('manage.status')}} {!! link_order('status') !!}</th>
                <th>{{trans('manage.views')}} {!! link_order('views') !!}</th>
                <th>{{trans('manage.created_at')}} {!! link_order('created_at') !!}</th>
                <th width="93">{{trans('manage.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td><input type="checkbox" name="checked[]" class="checkitem" value="{{ $item->id }}" /></td>
                <td>{{$item->id}}</td>
                <td>{{$item->title}}</td>
                <td>{{$item->slug}}</td>
                <td>{{$item->comment_count}}</td>
                <td>{{$item->str_status()}}</td>
                <td>{{$item->views}}</td>
                <td>{{$item->created_at}}</td>
                <td>
                    @if(cando('edit_my_post', $item->author_id))
                    <a href="{{route('page.edit', ['id' => $item->id])}}" class="btn btn-sm btn-info" title="{{trans('manage.edit')}}"><i class="fa fa-edit"></i></a>
                    @endif
                    
                    @if(request()->get('status') != 0 && cando('remove_my_post', $item->author_id))
                    {!! Form::open(['method' => 'delete', 'route' => ['page.destroy', $item->id], 'class' => 'form-inline remove-btn', 'title' => trans('manage.destroy')]) !!}
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    {!! Form::close() !!}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="paginate">
    {!! $items->render() !!}
</div>

@else
<p>{{trans('manage.no_item')}}</p>
@endif

@stop

