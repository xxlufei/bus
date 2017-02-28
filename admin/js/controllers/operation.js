app.controller('object_modal_ctrl', ['$scope','$http', '$modal', '$log','$state', function($scope, $http,$modal, $log, $state) {
    $scope.item = {};
    $scope.open = function (size) {
        $modal.open({
            templateUrl: 'operation.object.add.html',
            controller: 'OperationController',
            size: size,
            resolve: {
                object: function () {
                    return $scope.item;
                },
                api_version: function () {
                    return $scope.app.api_version;
                }
            }
    });
    };
    //选项卡
    $scope.object_tabs = [true, false];
    $scope.object_tab = function(index){
        angular.forEach($scope.object_tabs, function(i, v) {
            $scope.object_tabs[v] = false;
        });
        $scope.object_tabs[index] = true;
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
        $scope.params.objecttitle = '';
        $scope.get_objectlist($scope.bigCurrentPage,$scope.pageSize,null);
    };
    //获取用户总数
    $scope.objectlist=[];
    $scope.maxSize = 5;
    $scope.pageSize=25;
    $scope.bigTotalItems = 175;
    $scope.bigCurrentPage = 1;
    $scope.pageChanged = function() {
        //查询
        $scope.get_objectlist($scope.bigCurrentPage, $scope.pageSize, null);
    };


    $scope.object_remove = function (id) {
        $modal.open({
            templateUrl: 'confrim.html',
            controller: 'OperationController',
            size: 'sm',
            resolve: {
                object: function () {console.log(id);
                    return id;
                }
            }
        });
    };
    $scope.get_objectlist = function (current,pagesize,params) {
        $http.get('/admin/objectlist', {params:{current: current,pagesize:pagesize, params: params}}).then(function (response) {
            $scope.object_list = response.data.data;
            $scope.bigTotalItems = response.data.total;
        });
    };
    $scope.get_objectlist($scope.bigCurrentPage,$scope.pageSize,null);
}]);
app.controller('OperationController', ['$scope', '$http','$modalInstance','$modal','$state','object','$filter', function($scope,$http,$modalInstance,$modal, $state,object,$filter) {

    $scope.msg='确定删除吗?';
    $scope.formInvalid=true;
    $scope.date = {};
    if (object.type == 2) {
        $scope.object = object;
        $scope.page_title = '修改学科';
    } else {
        $scope.object = {};
        $scope.page_title = '新增学科';
    }
    $scope.authError = null;

    $scope.chkchange = function () {
        if ($scope.object.object_name ) {
            $scope.formInvalid=false;
        } else {
            $scope.formInvalid=true;
        }
    };

    $scope.confirm_ok = function() {
        $scope.confirm_button = true;
        $scope.authError = null;
        $http.delete('/admin/object_delete', {params:{o_id: object}})
            .then(function(response) {
                $modalInstance.dismiss('cancel');
                if (response.data.dec.code!="200000" ) {
                    toastr.error(response.data.dec.msg);
                }else{
                    //$modalInstance.dismiss('cancel');

                    toastr.success('删除成功');
                    $state.go('app.object.list',{},{reload:true});
                }
            }, function(x) {
                $scope.authError = '请正确填写信息';
            });
    };


    $scope.objectadd = function() {
        $scope.formInvalid=true;
        if (!$scope.object.object_id) {
                //成功
                $scope.authError = null;
                $http.post('/admin/object_add', {object_name: $scope.object.object_name})
                    .then(function(response) {
                        if (response.data.dec.code!="200000" ) {
                            toastr.error(response.data.dec.msg);
                        }else{
                            $modalInstance.dismiss('cancel');
                            toastr.success('保存成功');
                            $state.go('app.object.list',{},{reload:true});
                        }
                    }, function(x) {
                        $scope.authError = '请正确填写信息';
                    });
        } else {
            $http.post('/admin/object_update', {object_name: $scope.object.object_name, o_id: $scope.object.object_id})
                .then(function(response) {
                    if (response.data.dec.code!="200000" ) {
                        toastr.error(response.data.dec.msg);
                    }else{
                        $modalInstance.dismiss('cancel');
                        toastr.success('保存成功');
                        $state.go('app.object.list',{},{reload:true});
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
