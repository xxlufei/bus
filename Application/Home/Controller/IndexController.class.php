<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $prv = file_get_contents('p.txt');
        $prv = unserialize($prv);
        foreach($prv as $k => $val) {
            $prov = iconv('gbk', 'utf-8', $k);

           $pp =  M('province')->where("province_name = '$prov'")->find();

            foreach ($val as $kk=>$vv){
                $vv = iconv('gbk', 'utf-8', $vv);

                M('city')->add(['city_name'=>$vv, 'city_pinyin'=>$kk, 'province_id'=>$pp['province_id']]);
            }

        }
        var_dump($prv);exit;
        $city = M('city')->select();
        var_dump($city);exit;
    }
}