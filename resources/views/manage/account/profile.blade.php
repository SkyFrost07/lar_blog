@extends('layouts.manage')

@section('title', trans('auth.account_info'))

@section('page_title', trans('auth.account_info'))

@section('content')

{!! show_messes() !!}

<div class="row">
    <div class="col-sm-8">
        {!! Form::open(['method' => 'post', 'route' => 'mn.update_profile']) !!}
        <?php
        $user = auth()->user(); 
        ?>
        
        <div class="form-group row">
            <label class="col-sm-4">{{trans('auth.name')}}</label>
            <div class="col-sm-8">
                {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4">{{trans('auth.email')}}</label>
            <div class="col-sm-8">
                {!! Form::email('email', $user->email, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4">{{trans('auth.role')}}</label>
            <div class="col-sm-8">
                @if(cando('manage_users'))
                {!! Form::select('role_id', $roles, $user->role_id, ['class' => 'form-control']) !!}
                @else
                {!! Form::text('', $user->role->label, ['class' => 'form-control', 'disabled']) !!}
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4">{{trans('auth.gender')}}</label>
            <div class="col-sm-8">
                {!! Form::select('gender', [0 => trans('auth.undefined'), 1 => trans('auth.male'), 2 => trans('auth.female')], $user->gender, ['class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-4">{{trans('auth.avatar')}}</label>
            <div class="col-sm-8">
                <div class="thumb_item">
                    <a class="img_box avatar_img">
                        @if($user->image_id)
                        <img class="img-responsive" src="{{getImageSrc($user->image_id, 'thumbnail')}}" alt="avatar">
                        @endif
                    </a>
                    <input type="hidden" id="file_url" name="image_id" value="{{getImageSrc($user->image_id)}}">
                    <div class="btn_box">
                        @if($user->image_id)
                        <button type="button" class="close btn-remove-file"><i class="fa fa-close"></i></button>
                        @endif
                    </div>
                </div>
                <button type="button" class="btn btn-default btn-popup-files" frame-url="/plugins/filemanager/dialog.php?type=1&field_id=file_url&field_img=file_src" data-toggle="modal" data-target="#files_modal">{{trans('manage.add_image')}}</button>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-4">{{trans('auth.birth')}}</label>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-xs-4">
                        <select name="birth[day]" class="form-control">
                            {!! range_options(1, 31, $user->birth->format('d')) !!}
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select name="birth[month]" class="form-control">
                            {!! range_options(1, 12, $user->birth->format('m')) !!}
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select name="birth[year]" class="form-control">
                            {!! range_options(1970, 2030, $user->birth->format('Y')) !!}
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-4"></label>
            <div class="col-sm-8">
                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{trans('auth.save')}}</button>
                <a href="{{route('mn.change_pass')}}" class="btn btn-info"><i class="fa fa-lock"></i> {{trans('auth.change_pass')}}</a>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>

@stop

@section('foot')

<script src="/adminsrc/js/tinymce_script.js"></script>

@include('files.modal')

@stop

