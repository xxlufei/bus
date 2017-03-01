<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/15
 * Time: 22:15
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class DocController extends CommonController
{
    # 公文列表方法
    public function showList()
    {
        $model = D('Doc');
        $data = $model->select();
        $this->assign('data', $data);
        $this->display();
    }

    # 公文添加方法
    public function add()
    {
        $this->display();
    }

    # 公文提交数据库并跳转
    # 入口文件配置两个常量，用于文件上传路径时使用
    public function addOk()
    {
        $post = I('post.');
        $post['addtime'] = time();
        # 文件上传类配置项
        $cfg = array(
            'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH, // 保存根路径
        );
        # 实例化上传类
        $upload = new Upload($cfg);
        # 上传
        $info = $upload->uploadOne($_FILES['file']);
        # 判断上传的结果，失败返回值为false，
        if ($info) {
            $post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
            $post['filename'] = $info['savename'];
            $post['hasfile'] = 1;
        }
        $model = M('Doc');
        $rst = $model -> add($post);
        if ($rst) {
            $this->success('添加成功', U('showList'), 3);
        } else {
            $this->error('添加成功', U('add'), 3);
        }
    }

    # download 方法下载附件
    public function download()
    {
        $id = I('get.id');

        $model = M('Doc');
        $data = $model->find($id);
        # 拼凑文件路径
        $file = WORKING_PATH . $data['filepath'];
        #将文件输出
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        readfile($file);
    }

    # 利用laery显示content的方法
    public function getContent()
    {
        $id = I('get.id');
        $model = M('Doc');
        $data = $model->find($id);
        if ($data) {
            echo htmlspecialchars_decode($data['content']);
        }
    }

    # 编辑doc方法
    public function edit()
    {
        $id = I('get.id');
        $model = M('Doc');
        $rst = $model->find($id);
        # 接受数据到模板
        $this->assign('data', $rst);
        $this->display();
    }

    # 提交编辑数据返回showlist
    public function editOk()
    {
        $post = I('post.');
        if ($_FILES['file']['size'] > 0) {
            # 文件上传类配置项
            $cfg = array(
                'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
            );
            # 实例化上传类
            $upload = new Upload($cfg);
            # 上传
            $info = $upload->uploadOne($_FILES['file']);
            # 判断上传的结果，失败返回值为false，
            if ($info) {
                $post['filepath'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                $post['filename'] = $info['savename'];
                $post['hasfile'] = 1;
            }
        }
        $model = M('Doc');
        $rst = $model->save($post);

        if ($rst !== false) {
            $this->success('编辑成功', U('showList'), 3);
        } else {
            $this->error('编辑失败', U('edit', array('id' => $post['id'])), 3);
        }
    }

    # 删除 跳转
    public function del()
    {
        $ids = I('get.ids');
        $model = M('Doc');
        $rst = $model->delete($ids);
        if ($rst) {
            $this->success('删除成功', U('showList'), 3);
        } else {
            $this->error('删除失败', U('showList'), 3);
        }
    }
}