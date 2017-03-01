<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/12
 * Time: 17:55
 */

namespace Admin\Controller;


use Think\Controller;

class DeptController extends CommonController
{
    # 展示部门列表信息
    public function showList()
    {
        # 获取数据
        $model = D('Dept');
        # 查询
        $data = $model->select();
        foreach ($data as $key => $value) {
            # 二次查询，data是个二维数组，查询目的是获取id=pid所对应的的分类名字
            # 循环遍历数组 data[key][value],下面的info.name是pid对应的名字，然后把其赋给data[key][parentName]
            $info = $model->find($value['pid']);
            $data[$key]['pareanName'] = $info['name'];
        }
        # 引入外部函数tree.php，进行无限极分类
        load('@/tree');
        $data = getTree($data);# data增加了level字段，用于分类，缩进次数为level级,缩进$emsp
        # 缩进函数str_repeat();
        $this->assign('data', $data);
        $this->display();
    }

    # 用于展示添加部门信息的模板文件
    # 读取已经有的部门信息后展示模板
    public function add()
    {
        $model = D('Dept');
        $rst = $model->select();
        $this->assign('rst', $rst);
        $this->display();
    }

    # addOk方法，用于执行保存数据的操作
    public function addOk()
    {
        /*使用I方法接受post数据,post.后不加表示接受所有post数据
        $post = I('post.');*/
        # 保存操作
        # 实例化
        $model = M('Dept');
        # 创建数据对象
        $model->create();//为空时，使用post数据
        # 保存
        $rst = $model->add();
        if ($rst) {
            # success
            $this->success('添加成功', U('showList'), 3);
        } else {
            $this->error('添加失败', U('add'), 3);
        }
    }

    # 部门删除方法
    public function del()
    {
        # 接受id
        $ids = I('get.ids');
        # 删除操作
        $model = D('Dept');
        $rst = $model->delete($ids);
        # 判断并跳转
        if ($rst) {
            # success
            $this->success('删除成功', U('showList'), 3);
        } else {
            $this->error('删除失败', U('showList'), 3);
        }
    }

    # 部门编辑方法
    public function edit()
    {
        # 获取原数据
        $id = I('get.id');
        $model = D('Dept');
        $rst = $model -> find($id);
        # 查询全部的部门数据
        $data = $model->select();
        # 传值给模板
        $this->assign(array(
            'rst' => $rst,
            'data' => $data,
        ));
        # 渲染模板
        $this->display();
    }

    # 编辑保存方法
    public function editOk()
    {
        # 获取提交的数据
        $post = I('post.');
        # 实例化模型后修改数据库的数据
        $model = D('Dept');
        $rst = $model->save($post);
        # 判断并返回结果
        if ($rst !==false) {
            # success
            $this->success('修改成功', U('showList'), 3);
        } else {
            $this->error('修改失败', U('showList', array('id' => $post['id'])), 3);
        }
    }
}