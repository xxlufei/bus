app.controller('message_modal_ctrl', ['$scope','$http', '$modal', '$log','$state', function($scope, $http,$modal, $log, $state) {
    $scope.item = {};
    $scope.open = function (size) {
        $modal.open({
            templateUrl: 'operation.message.add.html',
            controller: 'OperationController',
            size: size,
            resolve: {
                message: function () {
                    return $scope.item;
                },
                api_version: function () {
                    return $scope.app.api_version;
                }
            }
    });
    };
    //选项卡
    $scope.message_tabs = [true, false];
    $scope.message_tab = function(index){
        angular.forEach($scope.message_tabs, function(i, v) {
            $scope.message_tabs[v] = false;
        });
        $scope.message_tabs[index] = true;
        if(index==1){
            $scope.get_user_trash_list();
        }
    };
    $scope.cancel = function () {
        $modalInstance.dismiss('cancel');

    };
    $scope.open_edit = function (item) {
        $scope.item = item;
        $scope.item.type = 2;
        $scope.open('sm');
    };
    $scope.open_add = function (size) {
        $scope.item.type = 1;
        $scope.open(size);
    };
    $scope.query_all=function () {
        $scope.params.messagetitle = '';
        $scope.get_messagelist($scope.bigCurrentPage,$scope.pageSize,null);
    };
    //获取用户总数
    $scope.messagelist=[];
    $scope.maxSize = 5;
    $scope.pageSize=25;
    $scope.bigTotalItems = 175;
    $scope.bigCurrentPage = 1;
    $scope.pageChanged = function() {
        //查询
        $scope.get_messagelist($scope.bigCurrentPage, $scope.pageSize, null);
    };


    $scope.message_remove = function (id) {
        $modal.open({
            templateUrl: 'confrim.html',
            controller: 'OperationController',
            size: 'sm',
            resolve: {
                message: function () {console.log(id);
                    return id;
                }
            }
        });
    };
    $scope.get_messagelist = function (current,pagesize,params) {
        $http.get('/admin/messagelist', {params:{current: current,pagesize:pagesize, params: params}}).then(function (response) {
            $scope.message_list = response.data.data;
            $scope.bigTotalItems = response.data.total;
        });
    };
    $scope.get_messagelist($scope.bigCurrentPage,$scope.pageSize,null);
}]);
app.controller('OperationController', ['$scope', '$http','$modalInstance','$modal','$state','message','$filter', function($scope,$http,$modalInstance,$modal, $state,message,$filter) {

    $scope.msg='确定删除吗?';
    $scope.formInvalid=true;
    $scope.date = {};
    if (message.type == 2) {
        $scope.message = message;
        $scope.page_title = '修改留言';
    } else {
        $scope.message = {};
        $scope.page_title = '新增留言';
    }
    $scope.authError = null;

    $scope.chkchange = function () {
        if ($scope.message.content ) {
            $scope.formInvalid=false;
        } else {
            $scope.formInvalid=true;
        }
    };

    $scope.confirm_ok = function() {
        $scope.confirm_button = true;
        $scope.authError = null;
        $http.delete('/admin/message_delete', {params:{o_id: message}})
            .then(function(response) {
                $modalInstance.dismiss('cancel');
                if (response.data.dec.code!="200000" ) {
                    toastr.error(response.data.dec.msg);
                }else{
                    //$modalInstance.dismiss('cancel');

                    toastr.success('删除成功');
                    setTimeout(function(){
                        $state.go('app.message.list',{},{reload:true});
                    }, 1000);

                }
            }, function(x) {
                $scope.authError = '请正确填写信息';
            });
    };


    $scope.messageadd = function() {
        $scope.formInvalid=true;
        if (!$scope.message.message_id) {
                //成功
                $scope.authError = null;
                $http.post('/admin/message_add', {content: $scope.message.content})
                    .then(function(response) {
                        if (response.data.dec.code!="200000" ) {
                            toastr.error(response.data.dec.msg);
                        }else{
                            $modalInstance.dismiss('cancel');
                            toastr.success('保存成功');
                            $state.go('app.message.list',{},{reload:true});
                        }
                    }, function(x) {
                        $scope.authError = '请正确填写信息';
                    });
        } else {
            $http.post('/admin/message_update', {content: $scope.message.content, o_id: $scope.message.message_id})
                .then(function(response) {
                    if (response.data.dec.code!="200000" ) {
                        toastr.error(response.data.dec.msg);
                    }else{
                        $modalInstance.dismiss('cancel');
                        toastr.success('保存成功');
                        $state.go('app.message.list',{},{reload:true});
                    }
                }, function(x) {
                    $scope.authError = '请正确填写信息';
                });
        }
    };
    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    }
}]);
