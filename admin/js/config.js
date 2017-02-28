// config

var app =  
angular.module('app')
  .config(
    [        '$controllerProvider', '$compileProvider', '$filterProvider', '$provide',
    function ($controllerProvider,   $compileProvider,   $filterProvider,   $provide) {
        // lazy controller, directive and service
        app.controller = $controllerProvider.register;
        app.directive  = $compileProvider.directive;
        app.filter     = $filterProvider.register;
        app.factory    = $provide.factory;
        app.service    = $provide.service;
        app.constant   = $provide.constant;
        app.value      = $provide.value;
    }
  ])
  .config(['$translateProvider', function($translateProvider){
    // Register a loader for the static files
    // So, the module will search missing translation tables under the specified urls.
    // Those urls are [prefix][langKey][suffix].
    $translateProvider.useStaticFilesLoader({
      prefix: 'l10n/',
      suffix: '.js'
    });
    // Tell the module what language to use by default
    $translateProvider.preferredLanguage('en');
    // Tell the module to store the language in the local storage
    $translateProvider.useLocalStorage();
  }])
    .factory('AuthService', function ($rootScope,$http, $cookieStore,md5) {
    var authService = {};

    authService.login = function (user) {
        toastr.success('正在登录中...');
        return $http
            .post('/admin/login', {admin_user: user.admin_user, admin_password: md5.createHash(user.admin_password)})
            .then(function (response) {
                if (response.data.dec.code != "200000") {
                    toastr.error(response.data.dec.msg);
                } else {
                    return response.data.data;
                }
            });
    };

    authService.isAuthenticated = function () {
        var l_user = $cookieStore.get("study_admin_login_user");
        if(l_user!=undefined){
            return true;
        }else{
            return false;
        }
    };

    // authService.isAuthorized = function (authorizedRoles) {
    //     if (!angular.isArray(authorizedRoles)) {
    //         authorizedRoles = [authorizedRoles];
    //     }
    //     var result = (authService.isAuthenticated() &&
    //     authorizedRoles.indexOf(Session.userRole) !== -1);
    //     return result;
    // };
    return authService;
})
    .constant('AUTH_EVENTS', {
        loginSuccess: 'auth-login-success',
        loginFailed: 'auth-login-failed',
        logoutSuccess: 'auth-logout-success',
        sessionTimeout: 'auth-session-timeout',
        notAuthenticated: 'auth-not-authenticated',
        notAuthorized: 'auth-not-authorized'
    })
    .directive('repeatFinish',function(){
    return {
        link: function(scope,element,attr){
            console.log(scope.$index)
            if(scope.$last == true){
                console.log('ng-repeat执行完毕')
                scope.$eval( attr.repeatFinish )
            }
        }
    }
})
//     .constant('USER_ROLES', {
//     all: '*',
//     admin: 'admin',
//     editor: 'editor',
//     guest: 'guest'
// })