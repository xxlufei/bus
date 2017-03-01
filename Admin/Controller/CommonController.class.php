<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/18
 * Time: 15:16
 */

namespace Admin\Controller;


use Think\Controller;

class CommonController extends Controller
{
    // 每次都要调用session信息来控制用户权限，所以每次执行的都是构造方法，因此利用构造方法来进行
    // 构造方法的编写来限制权限
    /*public function __construct()
    {
        parent::__construct();
        // 继承父类后继续实现自己功能
    }*/

    # TP框架中的构造方法
    public function _initialize()
    {
        $uid = session('uid');
        # empty不接收函数的返回值empty(session('id'))这种形式会报错
        if (empty($uid)) {
            $url = U('Public/login');
            /*header("Location:$url");exit;*/
            $script = "<script>window.top.location.href='$url';</script>";
            echo $script;
        }

        # RBAC权限判断
        $cname = strtolower(CONTROLLER_NAME);// 当前Controller名
        $aname = strtolower(ACTION_NAME); // 当前方法名
        # 获取权限的数组
        $auths = C('RBAC_AUTHS'); // 配置中权限数组，用于对比cname .'/' . aname 是否在其中
        # 获取用户组的id
        $roleid = session('role_id');
        # 获取当前用户的权限
        $auth = $auths['auth' . $roleid];
        # 判断权限
        if ($roleid != 1) {
            if (!in_array($cname . '/*', $auth) && !in_array($cname . '/' . $aname, $auth)) {
                $this->error('没有权限', U('Index/home'), 3);
            }
        }
    }
}