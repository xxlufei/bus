<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/11
 * Time: 14:35
 */

namespace Admin\Controller;


use Org\Net\IpLocation;
use Think\Controller;
use Think\Verify;

class TestController extends Controller
{
    public function index()
    {
        echo "这是后台admin分组下的Test控制器里的index方法";
    }

    #使用普通方法实例化自定义的模型；
    public function test1()
    {
        $model = new \Admin\Model\DeptModel();
        dump($model);
    }

    #使用D方法实例化模型
    public function test2()
    {
        $model = D('Dept');
        dump($model);
    }

    #filed 使用该方法查询部门列表中的id和name字段的信息
    #只有一个参数
    public function test3()
    {
        #实例化模型
        $model = D('Dept');

        #调用filed方法
        $model->field('id, name');
        #产生结果，打印
        $rst = $model->select();
        dump($rst);
    }

    #limit案例
    #两种用法
    public function test4()
    {
        $model = D('Dept');
        $model->limit(1);
        //$model->limit(0,1);
        $rst = $model->select();
        dump($rst);
    }

    # order  只有一个参数！！
    # SELECT * FROM tp_dept ORDER BY id DESC.
    # order 调用：$model->order('字段 升/降序');
    public function test5()
    {
        $model = D('Dept');
        $model->order('id DESC');
        $rst = $model->select();
        dump($rst);
    }

    # group 分组
    # SELECT name,count(*) AS count FROM tp_dept GROUP BY name;
    public function test6()
    {
        $model = D('Dept');
        $model->field('name, count(*) AS count');
        $model->group('name');
        $rst = $model->select();
        dump($rst);
    }

    # 连贯操作改写group分组查询
    public function test7()
    {
        $model = D('Dept');
        $rst = $model->field('name, count(*) AS count')->group('name')->select();
        dump($rst);
    }

    # 实例化特殊表
    public function test8()
    {
        $model = D('Student');
        dump($model);
    }

    # $session
    public function test9()
    {
        # 设置session；
        session('name', '从零开始');
        session('name2', '努力');
        # 获取
        dump($_SESSION);
        dump(session());
        # session('name', null);
        # session(null);
    }

    # cookie
    public function test10()
    {
        cookie('name', '形成学习的习惯',1200);
        dump($_COOKIE);
        dump(cookie());
        # cookie('name', null);
        $name = cookie('name');
        dump($name);
    }

    # 测试自定义函数库运行
    public function test11()
    {
        getNowTime();
    }

    #测试动态加载自定义外部文件，运行函数
    public  function test12()
    {
        info();
    }

    # 测试load加载当前分组下的外部文件并运行函数
    public function test13()
    {
        load('@/loadtest');
        testKitty();
    }

    # 验证码
    public function test14()
    {
        $cfg = array(
            'useZh'     =>  true,           // 使用中文验证码
            'useImgBg'  =>  true,           // 使用背景图片
            'fontSize'  =>  45,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'imageH'    =>  240,               // 验证码图片高度
            'imageW'    =>  300,               // 验证码图片宽度
            'length'    =>  2,               // 验证码位数
            'fontttf'   =>  'simhei.ttf',              // 验证码字体，不设置随机获取
            'bg'        =>  array(243, 251, 254),  // 背景颜色
            'reset'     =>  true,           // 验证成功后是否重置
            'zhSet'     => "吴冲",
        );
        $verify = new Verify($cfg);
        $verify->entry();
    }

    # iplocation.class.php运用
    public function test15()
    {
        $class = new IpLocation('qqwry.dat');
        $data = $class->getlocation('220.181.61.189');
        dump($data);
    }
}