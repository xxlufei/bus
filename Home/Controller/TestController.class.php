<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/11
 * Time: 14:35
 */

namespace Home\Controller;


use Think\Controller;

class TestController extends Controller
{
    public function index()
    {
        //传递数据给模板
        $date = date('Y-m-d H:i:s');
        $this->assign('date', $date);
        //展示模板
        $this->display('Index/index');
    }

    public function testDisplay()
    {
        #display渲染模板
        /*$this->display();*/

        #获取模板的内容
        $content = $this->fetch();
        dump($content);
    }

    #测试注释方法
    public function test2()
    {
        $this->display();
    }

    #一维数组的分配
    public function test3()
    {
        $arr1 = array(
            'Linux', 'Apache', 'Mysql', 'PHP',
        );
        $arr2 = array(
            'art1' => '西游记',
            'art2' => '三国演义',
            'art3' => '红楼梦',
        );
        $this->assign(array(
            'arr1' => $arr1,
            'arr2' => $arr2,
        ));
        $this->display();
    }

    #二维数组的分配
    public function test4()
    {
        $arr1 = array(array(
            'Linux', 'Apache', 'Mysql', 'PHP',
        ),array(
            'art1' => '西游记',
            'art2' => '三国演义',
            'art3' => '红楼梦',
        ));
        $this->assign(array(
            'arr1' => $arr1,
        ));
        $this->display();
    }

    #模板系统变量
    public function test5()
    {
        $this->display();
    }
    #模板中格式化时间戳
    public function test6()
    {
        $time = time();
        $str = 'AbcDeFsG';
        #定义空值，演示默认值
        $available = '';
        $a = 1;
        $b = 2;
        $this->assign(array(
            'time' =>  $time,
            'str'  =>  $str,
            'available' => $available,
            'a' => $a,
            'b' => $b,
        ));
        $this->display();
    }

    #volist
    public function test7()
    {
        #定义数组
        $arr = array(
            array('西游记', '一群男人和三个女人的故事', '一个女人和一群男人的故事', '三国演义'),
            array('贾宝玉', '林黛玉', '薛宝钗','曹雪芹'),
            array('高军', '赵翔', '吴冲', '高杰'),
        );
        $this->assign("arr",$arr);
        $this->display();
    }
}