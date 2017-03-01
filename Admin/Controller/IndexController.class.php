<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $this->display();
    }
    public function home()
    {
        $this->display();
    }

    # 空操作
    public function _empty()
    {
        echo ACTION_NAME . "<br />";
        echo "<span style='color:red;font-size: 30px;'>forbidden！<span>";
    }
}