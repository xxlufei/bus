'use strict';

/* Controllers */
  // signin controller
app.controller('SigninFormController', function($scope,$rootScope,$state,$stateParams,$window,AUTH_EVENTS,AuthService,$cookieStore) {
    $scope.user = {};
    $scope.authError = null;
    $scope.login = function() {
        AuthService.login($scope.user).then(function (data) {
            if(data!=undefined){
                $rootScope.$broadcast(AUTH_EVENTS.loginSuccess);
                $cookieStore.remove('study_admin_login_user');
                $cookieStore.put("study_admin_login_user",data);
                //$scope.setPowers(data.powers);
                //var redirect_uri = $stateParams.redirect_uri;
                setTimeout(function () {
                    toastr.success('登录成功');
                    $state.go('app.index',{},{reload:true});

                },1000);
            }

        }, function () {
            $rootScope.$broadcast(AUTH_EVENTS.loginFailed);
        });
    }
});
