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
        $uid = session('uname');
        # empty不接收函数的返回值empty(session('id'))这种形式会报错
        if (empty($uid)) {
            $url = U('Public/login');
            /*header("Location:$url");exit;*/
            $script = "<script>window.top.location.href='$url';</script>";
            echo $script;
        }
    }
}