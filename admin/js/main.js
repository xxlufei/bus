'use strict';

/* Controllers */
angular.module('app')
  .controller('AppCtrl', ['$scope', '$translate', '$localStorage','$state', '$window', 'AuthService','$cookieStore', '$location',
    function(              $scope,   $translate,   $localStorage , $state,   $window ,  AuthService , $cookieStore ,  $location) {
      // add 'ie' classes to html
      var isIE = !!navigator.userAgent.match(/MSIE/i);
      isIE && angular.element($window.document.body).addClass('ie');
      isSmartDevice( $window ) && angular.element($window.document.body).addClass('smart');
      // config
      $scope.app = {
        name: '后台管理系统',
        en_name: 'ADMIN',
        version: '1.0.0',
        api_version:'v1',
        domain:'http://www.study.com/',
        debug:false,
        // for chart colors
        color: {
          primary: '#7266ba',
          info:    '#23b7e5',
          success: '#27c24c',
          warning: '#fad733',
          danger:  '#f05050',
          light:   '#e8eff0',
          dark:    '#3a3f51',
          black:   '#1c2b36'
        },
        settings: {
          themeID: 1,
          navbarHeaderColor: 'bg-black',
          navbarCollapseColor: 'bg-white-only',
          asideColor: 'bg-black',
          headerFixed: true,
          asideFixed: true,
          asideFolded: false,
          asideDock: false,
          container: false
        }
      }
      $scope.$loading = false;
      // save settings to local storage
      if ( angular.isDefined($localStorage.settings) ) {
        $scope.app.settings = $localStorage.settings;
      } else {
        $localStorage.settings = $scope.app.settings;
      }
      $scope.$watch('app.settings', function(){
        if( $scope.app.settings.asideDock  &&  $scope.app.settings.asideFixed ){
          // aside dock and fixed must set the header fixed.
          $scope.app.settings.headerFixed = true;
        }
        // save to local storage
        $localStorage.settings = $scope.app.settings;
      }, true);

      // angular translate
      $scope.lang = { isopen: false };
      // $scope.langs = {cn:'简体中文',en:'English', de_DE:'German', it_IT:'Italian'};
      $scope.langs = {cn:'简体中文'};
      $scope.selectLang = $scope.langs[$translate.proposedLanguage()] || "简体中文";
      $scope.setLang = function(langKey, $event) {
        // set the current lang
        $scope.selectLang = $scope.langs[langKey];
        // You can change the language during runtime
        $translate.use(langKey);
        $scope.lang.isopen = !$scope.lang.isopen;
      };


      function isSmartDevice( $window )
      {
          // Adapted from http://www.detectmobilebrowsers.com
          var ua = $window['navigator']['userAgent'] || $window['navigator']['vendor'] || $window['opera'];
          // Checks for iOs, Android, Blackberry, Opera Mini, and Windows mobile devices
          return (/iPhone|iPod|iPad|Silk|Android|BlackBerry|Opera Mini|IEMobile/).test(ua);
      };
      // console.log($scope.userPowers);
      // $scope.isAuthorized = AuthService.isAuthorized;
      $scope.logout=function () {
        var redirect_uri = $location.path();
        redirect_uri = redirect_uri.replace(/\//g,'.').substr(1);
        $cookieStore.remove('study_admin_login_user');
        $state.go('login',{redirect_uri:redirect_uri},{reload:true});
      }

      $scope.jumpToUrl = function(path) {
        //TODO:add code here
        $location.path(path);
      };
      $scope.login_user = $cookieStore.get("study_admin_login_user");
      // console.log($scope.login_user);
      //跳到登陆页
      $scope.init_page = function () {
        if($scope.login_user==undefined || $scope.login_user=='undefined'){
          // console.log('tiaochu');
          $scope.jumpToUrl('/login');
        }
      };
      $scope.$on('$stateChangeSuccess',
          function(event, toState, toParams, fromState) {
            //console.log(fromState);  // 这个 toState 没有 person 的值 'good'
            if(fromState.url=='/login'){
              var ua = $window['navigator']['userAgent']
              if(ua.indexOf('Firefox')<0){
                $window.location.reload();
              }
              //
            }
          });
      $scope.get_file_path = function(file,oos_object){
        var date = new Date();
        var x="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        var filename="";
        var timestamp = date.getTime();
        for(var  i=0;i<19;i++)  {
          filename += x.charAt(Math.ceil(Math.random()*100000000)%x.length);
        }
        filename = timestamp+filename;
        var str = date.toLocaleString();
        var path = '/'+str.substr(0,str.indexOf(' '))+'/';
        var suffix = file.name.substr(file.name.lastIndexOf('.'));
        return  oos_object+path+filename+suffix;
      };
  }])
  .filter('cut', function () {
    return function (value, wordwise, max, tail) {
      if (!value) return '';

      max = parseInt(max, 10);
      if (!max) return value;
      if (value.length <= max) return value;

      value = value.substr(0, max);
      if (wordwise) {
        var lastspace = value.lastIndexOf(' ');
        if (lastspace != -1) {
          value = value.substr(0, lastspace);
        }
      }

      return value + (tail || ' …');
    };
  }).filter('trustHtml', function ($sce) {
  return function (input) {
    return $sce.trustAsHtml(input);
  }
}).filter('undefined_0', function () {
  return function (input) {
    if(input==undefined){
      return 0;
    }
    return input;
  }
});

