<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/17
 * Time: 21:04
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class EmailController extends CommonController
{
    # 发送页面
    public function send()
    {
        $user = M('User');
        $data = $user->select();
        $this->assign('data', $data);
        $this->display();
    }

    # 发送功能实现
    public function sendOk()
    {
        $post = I('post.');
        $post['addtime'] = time();
        $post['from_id'] = session('uid');
        if ($_FILES['file']['size'] > 0) {
            # 配置
            $cfg = array(
                'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
            );
            $upload = new Upload($cfg);
            $info = $upload->uploadOne($_FILES['file']);
            if ($info) {
                $post['file'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                $post['hasfile'] = 1;
                $post['filename'] = $info['savename'];
            }
        }
        $model = M('Email');
        $rst = $model->add($post);
        if ($rst) {
            $this->success('发送成功！', U('sendBox'), 3);
        } else {
            $this->error('发送失败', U('send'), 3);
        }
    }

    # 读取 展示数据
    public function sendBox()
    {
        $model = M('Email');
        # select t1.*,t2.truename from tp_email as t1,tp_user as t2 where t1.to_id=t2.id and from_id =uid
        $data = $model -> field('t1.*,t2.truename')
            ->table('tp_email as t1,tp_user as t2')
            ->where('t1.to_id=t2.id and from_id=' . session('uid'))
            ->select();
        $this->assign('data', $data);
        $this->display();
    }

    # download
    public function download()
    {
        $id = I('get.id');
        $model = M('Email');
        $data = $model->find($id);
        $file = WORKING_PATH . $data['file'];
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        readfile($file);
    }

    # 读取展示数据
    public function recBox()
    {
        $model = M('Email');
        # select t1.*,t2.truename from tp_email as t1,tp_user as t2 where t1.from_id = t2.id and to_id = session('uid');

        $data = $model->field('t1.*,t2.truename')
            ->table('tp_email AS t1,tp_user AS t2')
            ->where('t1.from_id=t2.id AND to_id='.session('uid'))
            ->select();
        $this->assign('data', $data);
        $this->display();
    }

    # 获取邮件内容
    public function getContent()
    {
        $id = I('get.id');
        $model = M('Email');
        $data = $model->where("id = $id and to_id=".session('uid'))->find($id);
        # 输出邮件内容
        if ($data) {
            $model->save(array('id' => $id, 'isread' => 1));
        }
        echo $data['content'];
    }

    # 获取当前用户未读信息的数量
    public function getMsgCount()
    {
        if (IS_AJAX) {
            $model = M('Email');
            $count = $model->where("isread = 0 AND to_id=" . session('uid'))
                ->count();
            echo $count;
        }
    }
}