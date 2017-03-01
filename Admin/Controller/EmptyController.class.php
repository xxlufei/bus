<?php
/**
 * Created by PhpStorm.
 * User: ml
 * Date: 2017/2/18
 * Time: 10:59
 */

namespace Admin\Controller;


use Think\Controller;

class EmptyController extends Controller
{
    public function _empty()
    {
       $this->display('Empty/error');
    }
}