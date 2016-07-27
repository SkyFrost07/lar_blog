@extends('layouts.manage')

@section('title', trans('manage.man_posts'))

@section('page_title', trans('manage.edit'))

@section('head')
<link rel="stylesheet" href="/adminsrc/css/select2.min.css">
@stop

@section('content')

{!! show_messes() !!}

{!! Form::open(['method' => 'put', 'route' => ['post.update', $item->id]]) !!}

<div class="row">
    <div class="col-sm-8">

        @include('manage.parts.lang_edit_tabs', ['route' => 'post.edit'])

        <div class="form-group">
            <label>{{trans('manage.name')}} (*)</label>
            {!! Form::text('locale[title]', $item->title, ['class' => 'form-control', 'placeholder' => trans('manage.name')]) !!}
            {!! error_field('locale.title') !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.slug')}}</label>
            {!! Form::text('locale[slug]', $item->slug, ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.content')}}</label>
            {!! Form::textarea('locale[content]', $item->content, ['class' => 'form-control editor_content', 'rows' => 15, 'placeholder' => trans('manage.content')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.excerpt')}}</label>
            {!! Form::textarea('locale[excerpt]', $item->excerpt, ['class' => 'form-control editor_excerpt', 'rows' => 5, 'placeholder' => trans('manage.excerpt')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.meta_keyword')}}</label>
            {!! Form::text('locale[meta_keyword]', $item->meta_keyword, ['class' => 'form-control', 'placeholder' => trans('manage.meta_keyword')]) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.meta_desc')}}</label>
            {!! Form::textarea('locale[meta_desc]', $item->meta_desc, ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.meta_desc')]) !!}
        </div>

    </div>
    <div class="col-sm-4">

        <div class="form-group thumb_box" ng-app="ngFile" ng-controller="FileCtrl">
            <label>{{trans('manage.thumbnail')}}</label>
            <div class="thumb_group" ng-if="checked_files.length > 0">
                <div class="thumb_item" ng-repeat="file in checked_files">
                    <img src="{% file.url %}" class="img-responsive">
                    <input type="hidden" name="image_id" value="{% file.id %}">
                    <button type="button" ng-click="removeFile(file)" class="close"><i class="fa fa-close"></i></button>
                </div>
            </div>
            <button type="button" ng-click="loadFile()" class="btn btn-default" data-toggle="modal" data-target="files_modal">{{trans('manage.add_image')}}</button>
        </div>
        
        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Trash'], $item->status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.comment_status')}}</label>
            {!! Form::select('status', [1 => 'Open', 0 => 'Close'], $item->comment_status, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.views')}}</label>
            {!! Form::number('views', $item->views, ['class' => 'form-control']) !!}
        </div>
        
        @if(cando('edit_other_posts'))
        <div class="form-group">
            <label>{{trans('manage.created_at')}}</label>
            <div class="time_group">
                <div class="t_field">
                    <span>{{trans('manage.day')}}</span>
                    <select name="time[day]">
                        {!! range_options(1, 31, $item->created_at->format('d')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.month')}}</span>
                    <select name="time[month]">
                        {!! range_options(1, 12, $item->created_at->format('m')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.year')}}</span>
                    <select name="time[year]">
                        {!! range_options(2010, 2030, $item->created_at->format('Y')) !!}
                    </select>
                </div>
            </div>
        </div>
        @endif
        
        <input type="hidden" name="lang" value="{{$lang}}">
        {!! error_field('lang') !!}

        <a href="{{route('post.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.update')}}</button>

    </div>
</div>

{!! Form::close() !!}

@stop

@section('foot')
<script src="/adminsrc/js/select2.min.js"></script>
<script src="/plugins/angular/angular.min.js"></script>
<script>
    (function ($) {
        $('.new_tags').select2({
            tags: true
        });
        $('.av_tags').select2();
    })(jQuery);
</script>
@stop

