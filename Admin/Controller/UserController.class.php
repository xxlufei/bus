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
    public function add()
    {
        $model = D('Dept');
        $data = $model->select();
        # 无限极分类
        load('@/tree');
        $data = getTree($data);
        $this->assign('data', $data);
        $this->display();
    }
    public function addOk()
    {
        $post = I('post.');
        $post['addtime'] = time();
        $model = D('User');
        /*$post = $model->create();*/
        $rst = $model->add($post);
        if ($rst) {
            $this->success('添加成功', U('showList'), 3);
        } else {
            $this->error('添加失败', U('add'), 3);
        }
    }

    # 职员列表信息方法
    # 运用page类进行分页
    public function showList()
    {
        $model = D('User');
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
        # 关联部门表查询部门名字
        $dept = M('Dept');
        foreach ($data as $key => $value) {
            $info = $dept->find($value['dept_id']);
            $data[$key]['deptName'] = $info['name'];
        }

        $this->assign(array(
            'data' => $data,
            'page' => $show,
            'count' => $count,
    ));
        $this->display();
    }

    # 编辑信息
    public function edit()
    {
        $id = $_GET['id'];
        $model = M('User');
        $data = $model->find($id);
        $dept = M('Dept');
        $rst = $dept->select();
        #无限极分类部门信息
        load('@/tree');
        $rst = getTree($rst);
        $this->assign('data', $data);
        $this->assign('rst', $rst);
        $this->display();
    }

    # 提交信息到数据库并跳转
    public function editOk()
    {
        $post = I('post.');
        $model = M('User');
        if ($post['password'] == "") {
            unset($post['password']);
        }
        $rst = $model->save($post);
        if($rst !== false) {
            $this->success('编辑成功', U('showList'), 3);
        } else {
            $this->error('编辑失败',U('edit'), 3);
        }
    }

    # 删除并跳转
    public function del()
    {
        $ids = I('get.id');
        # 实例化
        $model = M('User');
        $rst = $model->delete($ids);
        if ($rst) {
            $this->success('删除成功', U('showList'), 3);
        } else {
            $this->error('删除失败', U('showList'), 3);
        }
    }

    # charts方法，统计每个部门有多少人
    public function charts()
    {
        $model = M();# 不关联表，直接实例化父类模型
        $sql = "SELECT t1.name AS dept_name,count(t2.id) 
                  AS count FROM tp_dept AS t1 
                  LEFT JOIN tp_user AS t2 
                  ON t1.id = t2.dept_id 
                  GROUP BY dept_name 
                  HAVING count > 0;";
        $data = $model->query($sql);
        # 拼凑数据
        $str = '[';
        foreach ($data as $key => $value) {
            $str .= "['" . $value['dept_name'] . "'," . $value['count'] . "],";
        }
        $str = rtrim($str, ",");
        $str .= "]";
        # 变量的分配
        $this ->assign('str', $str);
        $this->display();
    }
}