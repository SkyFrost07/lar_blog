@extends('layouts.manage')

@section('title', trans('manage.man_options'))

@section('page_title', trans('manage.man_options'))

@section('actions')
{!! Form::open(['method' => 'post', 'route' => 'option.m_action', 'class' => 'form-inline action-form', 'title' => trans('manage.remove')]) !!}
{!! Form::hidden('action', 'remove') !!}
<button type="submit" class="btn btn-sm btn-danger navbar-btn"><i class="fa fa-remove"></i> {{trans('manage.remove')}}</button>
{!! Form::close() !!}
@stop

@section('table_nav')
@include('manage.parts.table_nav')
@stop

@section('content')

{!! show_messes() !!}

<div class="row">
    
    <div class="col-sm-8">

        @if(!$items->isEmpty())
        {!! Form::open(['method' => 'post', 'route' => 'option.update_all']) !!}
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" name="massdel" class="checkall"/></th>
                        <th>{{trans('manage.name')}} {!! link_order('option_key') !!}</th>
                        <th>{{trans('manage.value')}} {!! link_order('value') !!}</th>
                        <th>{{trans('manage.language')}} {!! link_order('lang_code') !!}</th>
                        <th>{{trans('manage.actions')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td><input type="checkbox" name="checked[]" class="checkitem" value="{{ $item->option_key }}" /></td>
                        <td>{{ $item->option_key }}</td>
                        <td><textarea name="{{$item->lang_code.'['.$item->option_key.']'}}" rows="1" class="form-control">{{ $item->value }}</textarea></td>
                        <td>{{ $item->lang_code }}</td>
                        <td>
                            <a href="{{route('option.delete', ['key' => $item->option_key])}}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>
        </div>
        {!! Form::close() !!}
        
        @else
        <p>{{trans('manage.no_item')}}</p>
        @endif
        
    </div>
    
    <div class="col-sm-4">
        {!! Form::open(['method' => 'post', 'route' => 'option.store']) !!}
        
        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            <input type="text" name="key" class="form-control" placeholder="{{trans('manage.name')}}">
            {!! error_field('key') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.value')}} (*)</label>
            <textarea name="value" rows="2" class="form-control" placeholder="{{trans('manage.value')}}"></textarea>
            {!! error_field('value') !!}
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.language')}}</label>
            <select name="lang_code" class="form-control">
                <option value="">{{trans('manage.selection')}}</option>
                @foreach(get_langs(['fields' => ['code']]) as $lang)
                <option value="{{$lang->code}}">{{$lang->code}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <button class="btn btn-info" type="submit"><i class="fa fa-plus"></i> {{trans('manage.create')}}</button>
        </div>
        
        {!! Form::close() !!}
    </div>
</div>

@stop

