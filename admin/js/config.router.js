'use strict';

/**
 * Config for the router
 */
angular.module('app')
  .run(
    [          '$rootScope', '$state', '$stateParams',
      function ($rootScope,   $state,   $stateParams) {
          $rootScope.$state = $state;
          $rootScope.$stateParams = $stateParams;
      }
    ]
  )
  .config(
    [          '$stateProvider', '$urlRouterProvider','$locationProvider',
      function ($stateProvider,   $urlRouterProvider,$locationProvider) {
          //$locationProvider.html5Mode(true);
          $urlRouterProvider
              .otherwise('/app/index');
          $stateProvider
                /*登录／注册 start*/
              .state('login', {
                  url: '/login',
                  templateUrl: 'tpl/login.html',
                  params:{redirect_uri:null},
                  resolve: {
                      deps: ['uiLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load( ['js/controllers/signin.js'] );
                          }]
                  }
              })
              /*登录／注册 end*/
              .state('app', {
                  abstract: true,
                  url: '/app',
                  templateUrl: 'tpl/app.html'
              })
              .state('app.index', {
                  url: '/index',
                  templateUrl: 'tpl/index.html',
                  params:{redirect_uri:null},
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load(['js/controllers/index.js']);
                          }]
                  }
              })
              //学科管理
              .state('app.object', {
                  url: '',
                  template: '<div ui-view class="fade-in-up"></div>'
              })
              .state('app.object.list', {
                  url: '/object',
                  params:{redirect_uri:null},
                  templateUrl: 'tpl/object.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                            return $ocLazyLoad.load('toaster').then(
                                function(){
                                    return $ocLazyLoad.load('js/controllers/operation.js');
                                }
                            );
                          }]
                  }
              })
              //留言管理
              .state('app.message', {
                  url: '',
                  template: '<div ui-view class="fade-in-up"></div>'
              })
              .state('app.message.list', {
                  url: '/message',
                  params:{redirect_uri:null},
                  templateUrl: 'tpl/message.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load('js/controllers/message.js');
                                  }
                              );
                          }]
                  }
              })
              //文件管理
              .state('app.file', {
                  url: '',
                  template: '<div ui-view class="fade-in-up"></div>'
              })
              .state('app.file.list', {
                  url: '/file',
                  params:{redirect_uri:null},
                  templateUrl: 'tpl/file.html',
                  resolve: {
                      deps: ['$ocLazyLoad',
                          function( $ocLazyLoad ){
                              return $ocLazyLoad.load('toaster').then(
                                  function(){
                                      return $ocLazyLoad.load('js/controllers/file.js');
                                  }
                              );
                          }]
                  }
              })


      }
    ]
  );
