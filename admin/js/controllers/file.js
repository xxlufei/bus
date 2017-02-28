app.controller('file_modal_ctrl', ['$scope','$http', '$modal', '$log','$state', function($scope,$http,$modal, $log, $state) {
    $scope.item = {};
    $scope.open = function (size) {
        $modal.open({
            templateUrl: 'operation.file.add.html',
            controller: 'OperationController',
            size: size,
            resolve: {
                file: function () {
                    return $scope.item;
                },
                api_version: function () {
                    return $scope.app.api_version;
                }
            }
    });
    };
    //选项卡
    $scope.file_tabs = [true, false];
    $scope.file_tab = function(index){
        angular.forEach($scope.file_tabs, function(i, v) {
            $scope.file_tabs[v] = false;
        });
        $scope.file_tabs[index] = true;
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
        $scope.params.filetitle = '';
        $scope.get_filelist($scope.bigCurrentPage,$scope.pageSize,null);
    };
    //获取用户总数
    $scope.filelist=[];
    $scope.maxSize = 5;
    $scope.pageSize=25;
    $scope.bigTotalItems = 175;
    $scope.bigCurrentPage = 1;
    $scope.pageChanged = function() {
        //查询
        $scope.get_filelist($scope.bigCurrentPage, $scope.pageSize, null);
    };


    $scope.file_remove = function (id) {
        $modal.open({
            templateUrl: 'confrim.html',
            controller: 'OperationController',
            size: 'sm',
            resolve: {
                file: function () {console.log(id);
                    return id;
                }
            }
        });
    };
    $scope.get_filelist = function (current,pagesize,params) {
        $http.get('/admin/filelist', {params:{current: current,pagesize:pagesize, params: params}}).then(function (response) {
            $scope.file_list = response.data.data;
            $scope.bigTotalItems = response.data.total;
        });
    };
    $scope.get_filelist($scope.bigCurrentPage,$scope.pageSize,null);
}]);
app.controller('OperationController', ['$scope', '$http','$modalInstance','$modal','$state','file','$filter', function($scope,$http,$modalInstance,$modal, $state,file,$filter) {

    $scope.msg='确定删除吗?';
    $scope.formInvalid=true;
    $scope.date = {};

    $scope.file = {};
    $scope.page_title = '新增课件';

    $scope.authError = null;

    $scope.chkchange = function () {
        if ($scope.file.file_name && $scope.file.file) {
            $scope.formInvalid=false;
        } else {
            $scope.formInvalid=true;
        }
    };

    $scope.confirm_ok = function() {
        $scope.confirm_button = true;
        $scope.authError = null;
        $http.delete('/admin/file_delete', {params:{o_id: file}})
            .then(function(response) {
                $modalInstance.dismiss('cancel');
                if (response.data.dec.code!="200000" ) {
                    toastr.error(response.data.dec.msg);
                }else{
                    toastr.success('删除成功');
                    setTimeout(function () {
                        $state.go('app.file.list', {}, {reload: true});
                    }, 1000);
                }
            }, function(x) {
                $scope.authError = '请正确填写信息';
            });
    };

    $scope.fileadd = function() {
        $scope.formInvalid='123';
        $("#form1").ajaxSubmit({
            url: "file_add",
            dataType: 'json',
            async: true,
            success: function (response) {
                if (response.dec.code!="200000" ) {
                    toastr.error(response.dec.msg);
                }else {
                    $scope.formInvalid='123';
                    $modalInstance.dismiss('cancel');
                    toastr.success('保存成功');
                    setTimeout(function () {
                        $state.go('app.file.list', {}, {reload: true});
                    }, 1000);
                }
            }
        })
    };
    $scope.get_objectlist = function () {
        $http.get('/admin/objectlistall', {params:{}}).then(function (response) {
            $scope.object_list = response.data.data;
            $scope.selected = response.data.data[0].object_id;
        });
    };
    $scope.get_objectlist();
        /*单击提交*/

    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    }
}]);
