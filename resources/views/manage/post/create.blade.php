@extends('layouts.manage')

@section('title', trans('manage.man_posts'))

@section('page_title', trans('manage.create'))

@section('head')
<link rel="stylesheet" href="/adminsrc/css/select2.min.css">
@stop

@section('content')

{!! show_messes() !!}

<?php $langs = get_langs(); ?>

{!! Form::open(['method' => 'post', 'route' => 'post.store']) !!}

<div class="row">
    <div class="col-sm-8">

        @include('manage.parts.lang_tabs')

        <div class="tab-content">
            @foreach($langs as $lang)
            <?php $code = $lang->code; ?>
            <div class="tab-pane fade in {{ locale_active($code) }}" id="tab-{{$lang->code}}">

                <div class="form-group">
                    <label>{{trans('manage.name')}} (*)</label>
                    {!! Form::text($code.'[title]', old($code.'.title'), ['class' => 'form-control', 'placeholder' => trans('manage.title')]) !!}
                    {!! error_field($code.'.title') !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.slug')}}</label>
                    {!! Form::text($code.'[slug]', old($code.'.slug'), ['class' => 'form-control', 'placeholder' => trans('manage.slug')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.content')}}</label>
                    {!! Form::textarea($code.'[content]', old($code.'.content'), ['class' => 'form-control editor_content', 'rows' => 15, 'placeholder' => trans('manage.content')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.excerpt')}}</label>
                    {!! Form::textarea($code.'[excerpt]', old($code.'.excerpt'), ['class' => 'form-control editor_excerpt', 'rows' => 5, 'placeholder' => trans('manage.excerpt')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.meta_keyword')}}</label>
                    {!! Form::text($code.'[meta_keyword]', old($code.'.meta_keyword'), ['class' => 'form-control', 'placeholder' => trans('manage.meta_keyword')]) !!}
                </div>

                <div class="form-group">
                    <label>{{trans('manage.meta_desc')}}</label>
                    {!! Form::textarea($code.'[meta_desc]', old($code.'.meta_desc'), ['class' => 'form-control', 'rows' => 2, 'placeholder' => trans('manage.meta_desc')]) !!}
                </div>

            </div>
            @endforeach
        </div>

    </div>

    <div class="col-sm-4">

        <div class="form-group">
            <label>{{trans('manage.status')}}</label>
            {!! Form::select('status', [1 => 'Active', 0 => 'Trash'], old('status'), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.categories')}}</label>
            <ul class="cat-check-lists">
                {!! cat_check_lists($cats, old('cat_ids') ? old('cat_ids') : []) !!}
            </ul>
        </div>

        <div class="form-group">
            <label>{{trans('manage.new_tags')}}</label>
            <select name="new_tags[]" multiple class="new_tags form-control">
                @if(old('new_tags'))
                @foreach(old('new_tags') as $tag)
                <option selected value="{{$tag}}">{{$tag}}</option>
                @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label>{{trans('manage.available_tags')}}</label>
            <select name="tag_ids[]" multiple class="av_tags form-control">
                <?php $old_tag_ids = old('tag_ids') ? old('tag_ids') : []; ?>
                @foreach($tags as $tag)
                <option value="{{$tag->id}}" {{ in_array($tag->id, $old_tag_ids) ? 'selected' : '' }}>{{$tag->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>{{trans('manage.comment_status')}}</label>
            {!! Form::select('status', [1 => 'Open', 0 => 'Close'], old('comment_status'), ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            <label>{{trans('manage.views')}}</label>
            {!! Form::number('views', old('views'), ['class' => 'form-control']) !!}
        </div>
        
        @if(cando('edit_other_posts'))
        <div class="form-group">
            <label>{{trans('manage.created_at')}}</label>
            <div class="time_group">
                <div class="t_field">
                    <span>{{trans('manage.day')}}</span>
                    <select name="time[day]">
                        {!! range_options(1, 31, date('d')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.month')}}</span>
                    <select name="time[month]">
                        {!! range_options(1, 12, date('m')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.year')}}</span>
                    <select name="time[year]">
                        {!! range_options(2010, 2030, date('Y')) !!}
                    </select>
                </div>
            </div>
<!--            <div class="time_group">
                <div class="t_field">
                    <span>{{trans('manage.hour')}}</span>
                    <select name="time[hour]">
                        {!! range_options(0, 24, date('H')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.minute')}}</span>
                    <select name="time[minute]">
                        {!! range_options(0, 60, date('i')) !!}
                    </select>
                </div>
                <div class="t_field">
                    <span>{{trans('manage.second')}}</span>
                    <select name="time[second]">
                        {!! range_options(0, 60, date('s')) !!}
                    </select>
                </div>
            </div>-->
        </div>
        @endif

        <div class="form-group">
            <a href="{{route('post.index', ['status' => 1])}}" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> {{trans('manage.back')}}</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{trans('manage.create')}}</button>
        </div>

    </div>
</div>

{!! Form::close() !!}

@stop

@section('foot')
<script src="/adminsrc/js/select2.min.js"></script>
<script>
(function ($) {
    $('.new_tags').select2({
        tags: true
    });
    $('.av_tags').select2();
})(jQuery);
</script>
@stop

