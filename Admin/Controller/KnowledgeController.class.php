<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/17
 * Time: 18:31
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Image;
use Think\Upload;

class KnowledgeController extends CommonController
{
    public function showList()
    {
        $model = M('Knowledge');
        $data = $model->select();
        $this->assign('data', $data);
        $this->display();
    }

    public function add()
    {
        $this->display();
    }

    public function addOk()
    {
        $post = I('post.');
        $post['addtime'] = time();
        if ($_FILES['thumb']['size'] > 0) {
            # 上传处理
            #配置
            $cfg = array(
                'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
            );
            # 实例化
            $upload = new Upload($cfg);
            # 上传
            $info = $upload->uploadOne($_FILES['thumb']);
            # 判断
            if ($info) {
                # 上传成功，添加字段
                $post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] . $info['savename'];
                /*
                 *
                 * */
                # 生成缩略图 添加thumb 字段
                # 步骤： 打开图片open、制作缩略图thumb、保存缩略图save
                $image = new Image();
                $pic = WORKING_PATH . $post['picture'];
                $image->open($pic);
                // 缩减
                $image->thumb(100, 100);  //等比缩放；后面的参数可能不能用
                // 保存
                $pos = WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
                $image->save($pos);
                $post['thumb'] = UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
            }
        }
        $model = M('Knowledge');
        $rst = $model->add($post);
        if ($rst) {
            $this->success('添加成功', U('showList'), 3);
        } else {
            $this->error('添加失败', U('add'), 3);
        }
    }

    public function edit()
    {
        $id = I('get.id');
        $model = M('Knowledge');
        $data = $model->find($id);
        $this->assign('data', $data);
        $this->display();
    }

    public function editOk()
    {
        $post = I('post.');
        if ($_FILES['thumb']['size'] > 0) {
            // 上传附件并且保存
            $cfg = array(
                'rootPath' => WORKING_PATH . UPLOAD_ROOT_PATH,
            );
            $upload = new Upload($cfg);
            $info = $upload->uploadOne($_FILES['thumb']); // 上传完成
            if ($info) {
                // 如果info为真，上传成功，制作缩略图
                $post['picture'] = UPLOAD_ROOT_PATH . $info['savepath'] .  $info['savename'];
                $im = new Image();
                # 打开图片
                $picpath = WORKING_PATH . $post['picture'];
                $im->open($picpath);
                # 制作缩略图
                $im->thumb(100, 100);
                # 保存
                $thumbpath = WORKING_PATH . UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
                $im->save($thumbpath);
                // 设置thump的字段
                $post['thumb'] = UPLOAD_ROOT_PATH . $info['savepath'] . 'thumb_' . $info['savename'];
            }

        }
        $model = M('Knowledge');
        $rst = $model->save($post);
        if ($rst !== false) {
            $this->success('修改成功喽', U('showList'), 3);
        } else {
            $this->error('没改成，再看看', U('edit', array('id' => $post['id'])), 3);
        }
    }

    public function del()
    {
        $ids = I('get.ids');
        $model = M('Knowledge');
        $rst = $model->delete($ids);
        if ($rst) {
            $this->success('删除成功了', U('showList'), 3);
        } else {
            $this->error('删除失败', U('showList'), 3);
        }
    }
}