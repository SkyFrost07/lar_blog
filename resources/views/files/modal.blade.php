<div ng-app="ngFile">
    <div class="modal fade" id="files_modal" tabindex="-1" role="dialog" ng-controller="FileCtrl">
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
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="tab_upload">
                            <input type="file" name="files[]" id="input_files" ng-model="inputFiles" ng-change="uploadFiles()">
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_select_files">
                            <div id="files_list" ng-if="files.length > 0">
                                <a href="javascript:void(0)" ng-repeat="file in files" ng-click="checkFile(file)"><img src="{% file.url %}"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('file.close')}}</button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-check"></i> {{trans('file.submit_selected')}}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<script src="/plugins/angular/angular.min.js"></script>
<script src="/adminsrc/js/app.js"></script>
<script src="/adminsrc/js/files_upload.js"></script>
<script>
                    (function ($) {
                        var args = top.tinymce.activeEditor.windowManager.getParams();
                        var editor = args.editor;

//                $('body').on('click', '#files b', function(e){
//                   e.preventDefault();
//                   editor.insertContent($(this).attr('href'));
//                   editor.windowManager.close();
//                });
                    })(jQuery);
                    
                    angular.module('ngApp', [])
                            .config(function ($interpolateProvider) {
                                $interpolateProvider.startSymbol('{%');
                                $interpolateProvider.endSymbol('%}');
                            })
                            .controller('FileCtrl', function ($scope) {
                                $scope.files = [
                                    {title: 'File 1', url: 'url1'},
                                    {title: 'File 2', url: 'url2'},
                                    {title: 'File 3', url: 'url3'},
                                    {title: 'File 4', url: 'url4'}
                                ];

                                $scope.checked_files = [];
                                $scope.checkFile = function (file, multi) {
                                    $scope.proccessing = false;
                                    if (typeof multi == "undefined") {
                                        multi = false;
                                    }
                                    if (!multi) {
                                        $scope.checked_files[0] = file;
                                    } else {
                                        var index = $scope.checked_files.indexOf(file);
                                        if (index > -1) {
                                            $scope.checked_files.splice(index, 1);
                                        } else {
                                            $scope.checked_files.push(file);
                                        }
                                    }
                                    console.log($scope.checked_files);
                                };

                                $scope.files = [];
                            })
                            .directive('fileUpload', function ($http) {
                                return {
                                    restrict: 'A',
                                    link: function (scope, element, attrs) {
                                        element.bind('change', function (event) {
                                            scope.$apply(function () {
                                                var files = event.target.files || event.dataTransfer.files;
                                                var form = $(element).parent()[0];
                                                var formData = new FormData();
                                                for (var i = 0; i < files.length; i++) {
                                                    formData.append('files[]', files[i]);
                                                }
                                                $http({
                                                    method: 'POST',
                                                    url: '/test/upload',
                                                    data: formData,
                                                    headers: {'Content-type': undefined}
                                                }).success(function (data) {
                                                    console.log(data);
                                                }).error(function (error) {
                                                    console.log(error);
                                                });
                                            });
                                        });
                                    }
                                };
                            });
</script>

