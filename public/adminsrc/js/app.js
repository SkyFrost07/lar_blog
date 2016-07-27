(function () {
    
    angular.module('ngFile', [])
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
                    if (typeof multi === "undefined") {
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
            });
})();


