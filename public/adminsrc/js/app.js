angular.module('ngFile', [])
        .config(function ($interpolateProvider) {
            $interpolateProvider.startSymbol('{%');
            $interpolateProvider.endSymbol('%}');
        })
        .controller('FileCtrl', function ($scope, $rootScope, $http) {
            $scope.checked_files = [];
            $scope.checkFile = function (file, multi) {
                $scope.proccessing = false;
                if (typeof multi == "undefined") {
                    multi = false;
                }

                var index = $scope.checked_files.indexOf(file);
                if (index > -1) {
                    $scope.checked_files.splice(index, 1);
                } else {
                    if(multi){
                        $scope.checked_files.push(file);
                    }else{
                        $scope.checked_files = [];
                        $scope.checked_files[0] = file;
                    }
                }
            };
            $rootScope.submit_files = [];
            $scope.submitChecked = function () {
                $rootScope.submit_files = $scope.checked_files;
                var modal = jQuery('#files_modal');
                modal.modal('hide');
            };
        })
        .controller('selectFileCtrl', function ($scope, $rootScope, $http) {
            $scope.loadFiles = function (multi_check) {
                $rootScope.multi_check = multi_check;
                $http.get('/' + current_locale + '/manage/files', {
                    params: {'fields[]': ['id', 'rand_dir', 'url']}
                }).then(function (response) {
                    $rootScope.files = response.data.data; 
                    $scope.$emit('loaded-files', response.data.data);
                }).catch(function (err) {
                    console.log(err);
                });
            };
            $scope.removeFile = function(file){
                var index = $rootScope.submit_files.indexOf(file);
                $rootScope.submit_files.splice(index, 1);
            };
        })
        .directive('ngThumb', function ($http) {
            return {
                restrict: 'A',
                link: function (scope, element, attrs) {
                    attrs.$observe("fileId", function (file_id) {
                        var size = attrs.ngThumb;
                        $http.get('/' + current_locale + '/manage/files/' + file_id, {params: {size: size}}).then(function (response) {
                            element.html(response.data);
                        });
                    });
                }
            };
        })
        .directive('fileUpload', function ($http, $rootScope) {
            return {
                restrict: 'A',
                link: function (scope, element, attrs) {
                    element.bind('change', function (event) {
                        scope.$apply(function () {
                            var files = event.target.files || event.dataTransfer.files;
                            var formData = new FormData();
                            for (var i = 0; i < files.length; i++) {
                                formData.append('files[]', files[i]);
                            }
                            $http({
                                method: 'POST',
                                url: '/'+current_locale+'/manage/files',
                                data: formData,
                                headers: {'Content-type': undefined}
                            }).success(function (data) {
                                $rootScope.files = data.concat($rootScope.files);
                                $('#input_files').val('');
                                $('a[href="#tab_select_files"]').click();
                            }).error(function (error) {
                                console.log(error);
                            });
                        });
                    });
                }
            };
        });



