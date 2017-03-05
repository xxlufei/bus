<?php
/**
 * Created by PhpStorm.
 * User: ihere
 * Date: 2017/3/4
 * Time: 19:29
 */

namespace Home\Controller;


use Think\Controller;

class UserController extends Controller
{
    //个人中心
    public function show()
    {
        $session = session('user');
        $messages = M('message')->where('user_id = '.$session['user_id'])->select();

        $this->assign(array(
            'session' => $session,
            'messages' => $messages,
        ));
        $this->display();
    }

    //修改密码
    public function password()
    {
        $post = I();
        $session = session('user');
        if (empty($session['user_id'])) {
            $this->error('用户未登录', U('Index/login'), 3);
        }
        if (empty($post['old_password'])) {
            $this->error('原密码不能为空', U('show'), 3);
        }
        if (empty($post['pwd']) || empty($post['repwd']) || $post['pwd'] !== $post['repwd']) {
            $this->error('新密码为空或两次输入不一致', U('show'), 3);
        }
        if ($post['pwd'] == $post['old_password']) {
            $this->error('新旧密码不能相同', U('show'), 3);
        }
        $user = M('users')->where('user_id = '.$session['user_id'])->find();
        if ($user['password'] != md5($post['old_password'])) {
            $this->error('原密码错误', U('show'), 3);
        }

        $res = M('users')->where('user_id = '.$user['user_id'])->save(['password'=>md5($post['pwd'])]);
        if ($res) {
            $this->success('修改成功', U('Index/index'), 3);
        } else {
            $this->error('修改失败', U('show'), 3);
        }
    }

    public function message()
    {
        $session = session('user');
        $messages = M('message')->where('user_id = '.$session['user_id'])->select();

        $this->assign(array(
            'session' => $session,
            'messages' => $messages,
        ));
        $this->display();
    }

    public function add_message()
    {
        $post = I();
        $data['user_id'] = $post['user_id'];
        $data['content'] = $post['content'];
        $data['create_at'] = time();
        $id = M('message')->add($data);
        if ($id) {
            echo 200000;return;
        } else {
            echo 10000;return;
        }

    }
}