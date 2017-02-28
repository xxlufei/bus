'use strict';
app.controller('FlotChartDemoCtrl', ['$scope','$rootScope','$state','$http', function($scope,$rootScope,$state,$http) {
     //$state.go('app.index',{},{reload:true});
    $scope.showSpline = true;
    $scope.chart_data={};
    $scope.upv_da = [106,108,110,105,110,109,105,110,107];
    $scope.d0_1 = [];
    $scope.d0_2 = [];
    $scope.d0_max=20;console.log($scope.showSpline);

    $rootScope.$broadcast('event:apiRequestStart');
    $rootScope.$broadcast('event:apiRequestSuccess');
    $rootScope.$emit('$viewContentLoaded');

}]);