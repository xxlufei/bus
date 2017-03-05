<?php
/**
 * Created by PhpStorm.
 * User: ihere
 * Date: 2017/3/1
 * Time: 15:16
 */

namespace Admin\Controller;

use Think\Page;
class MessageController extends CommonController
{
    public function showList()
    {
        $model = D('message');
        # 查询总记录数，用于分页
        $count = $model->count();
        # 实例化分页类并且将count数值、每页显示信息数传值
        $page = new Page($count, 10);
        # 可选 进行分页信息的配置
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','末页');
        $page->lastSuffix = false;
        # 生成页面等信息
        $show = $page->show();
        # limit 查询结果
        $data = $model->join('LEFT JOIN bus_users ON bus_users.user_id = bus_message.user_id')->limit($page->firstRow,$page->listRows)->field('content, message_id,bus_users.nickname,reply')->select();
        $this->assign(array(
            'data' => $data,
            'page' => $show,
            'count' => $count,
        ));
        $this->display();
    }

    public function reply()
    {
        $post = I();
        $res = M('message')->where('message_id = '.$post['message_id'])->save(['reply'=>$post['reply'], 'reply_at'=>time()]);
        if ($res) {
            $this->success('回复成功', U('showList'), 3);
        } else {
            $this->error('回复失败', U('showList'), 3);
        }
    }

    # 删除并跳转
    public function del()
    {
        $ids = I('get.id');
        # 实例化
        $model = M('message');
        $rst = $model->delete($ids);
        if ($rst) {
            $this->success('删除成功', U('showList'), 3);
        } else {
            $this->error('删除失败', U('showList'), 3);
        }
    }
}