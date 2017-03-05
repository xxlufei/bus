<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/15
 * Time: 13:08
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Page;
class UserController extends CommonController
{
    # 运用page类进行分页
    public function showList()
    {
        $model = D('users');
        # 查询总记录数，用于分页
        $count = $model->count();
        # 实例化分页类并且将count数值、每页显示信息数传值
        $page = new Page($count, 2);
        # 可选 进行分页信息的配置
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','末页');
        $page->lastSuffix = false;
        # 生成页面等信息
        $show = $page->show();
        # limit 查询结果
        $data = $model->limit($page->firstRow,$page->listRows)->select();
        $this->assign(array(
            'data' => $data,
            'page' => $show,
            'count' => $count,
    ));
        $this->display();
    }

    # 删除并跳转
    public function del()
    {
        $ids = I('get.id');
        # 实例化
        $model = M('users');
        $rst = $model->delete($ids);
        if ($rst) {
            $this->success('删除成功', U('showList'), 3);
        } else {
            $this->error('删除失败', U('showList'), 3);
        }
    }

}