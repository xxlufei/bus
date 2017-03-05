<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/11
 * Time: 20:23
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Verify;

class PublicController extends Controller
{
    //login方法，展示oa系统登录页面
    public function login()
    {
        $this->display();
    }

    public function captcha()
    {
        $cfg = array(
            'useImgBg'  =>  false,           // 使用背景图片
            'fontSize'  =>  12,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'imageH'    =>  38,               // 验证码图片高度
            'imageW'    =>  79,               // 验证码图片宽度
            'length'    =>  4,               // 验证码位数
            'fontttf'   =>  '4.ttf',              // 验证码字体，不设置随机获取
            'bg'        =>  array(243, 251, 254),  // 背景颜色
            'reset'     =>  true,           // 验证成功后是否重置
        );
        $verify = new Verify($cfg);
        $verify->entry();
        $this->display();
    }

    # 处理用户登录
    public function index()
    {
        $post = I('post.');
        $verify = new Verify();
       /* # 创建数据对象 不能用 因为验证码不在数据库中
        $post = $model->create();//为空时，使用post数据 */
       # 获取表单验证码信息与当前生成的验证码对比
        $rst = $verify->check($post['captcha']);
        if ($rst) {
            # 验证码成功,执行实例化模型查询数据操作
            $model = D('admin_user');
            # 获取提交表单信息后与实例化user表中的username password对比
            $result = $model->where(array(
                'admin_name' => $post['username'],
                'admin_password' => md5($post['password']),
            ))->find();
            if ($result) {
                # 持久化
                session('uname', $result['admin_nickname']);
                //session('uname', $result['username']);
                //session('role_id', $result['role_id']);
                $this->success('登录成功！', U('Index/index'), 3);
            } else {
                # 用户名或密码错误
                $this->error('用户名或密码错误', U('login'), 3);
            }
        } else {
            # 验证码错误
            $this->error('验证码错误', U('login'), 3);
        }
    }

    #logout
    public function logout()
    {
        session(null);
        $this->success('退出成功', U('Public/login'), 4);
    }
}
