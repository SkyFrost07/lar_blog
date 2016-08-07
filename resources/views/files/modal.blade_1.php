<div class="modal fade" id="files_modal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{trans('file.modal_title')}}</h4>
            </div>
            <div class="modal-body">
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
            <div class="modal-footer">
                @if(isset($item) && $item->thumb_id)
                <input type="hidden" ng-init='checked_files=[{"id": "{{$item->thumb_id}}"}]'>
                @endif
                <div class="pull-left" ng-if="checked_files.length > 0">
                    {% checked_files.length %} {{trans('file.is_selected')}}
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('file.close')}}</button>
                <button type="button" ng-click="submitChecked()" class="btn btn-primary"><i class="fa fa-check"></i> {{trans('file.submit_selected')}}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
                    var current_locale = '<?php echo current_locale(); ?>';
</script>
<script src="/plugins/angular/angular.min.js"></script>
<script src="/adminsrc/js/app.js"></script>

