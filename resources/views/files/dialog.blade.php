<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=divice-width, initial-scale=1">

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/adminsrc/css/main.css">
        <script src="/js/jquery.min.js"></script>
        <script>
            var _token = '<?php echo csrf_token(); ?>';
        </script>

    </head>
    <body ng-app="ngFile" ng-controller="FileCtrl">

        <div class="dialog-body">
            <ul class="nav nav-tabs file_tabs" role="tablist">
                <li class="active"><a href="#tab_upload" data-toggle="tab">{{trans('file.upload')}}</a></li>
                <li><a href="#tab_select_files" data-toggle="tab">{{trans('file.select_files')}}</a></li>
            </ul>
            <br />

            <!-- Tab panes -->
            <div class="tab-content file_tab_contents">
                <div role="tabpanel" class="tab-pane fade in active" id="tab_upload">
                    <input type="file" name="files[]" id="input_files" file-upload multiple>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_select_files">
                    <div class="files_list" ng-if="files.length > 0">
                        <a href="javascript:void(0)" 
                           class="file " ng-class="{'checked' : inCheckedFiles(item)}" 
                           ng-repeat="item in files" 
                           ng-click="checkFile(item, multi_check)" 
                           ng-thumb="thumbnail" 
                           file-id="{% item.id %}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="dialog-footer text-right">
            @if(isset($item) && $item->thumb_id)
            <input type="hidden" ng-init='checked_files = [{"id":"{{$item->thumb_id}}"}]'>
            @endif
            <div class="pull-left" ng-if="checked_files.length > 0">
                {% checked_files.length %} {{trans('file.is_selected')}}
            </div>
            <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('file.close')}}</button>
            <button type="button" ng-click="submitChecked()" class="btn btn-primary"><i class="fa fa-check"></i> {{trans('file.submit_selected')}}</button>
        </div>

    </body>

    <script src="/js/bootstrap.min.js"></script>

    <script>
        var files_url = '<?php echo route('file.index') ?>';
                var current_locale = '<?php echo current_locale(); ?>';
                
                
    </script>
    <script src="/plugins/angular/angular.min.js"></script>
    <script src="/adminsrc/js/dialog.js"></script>

</html>