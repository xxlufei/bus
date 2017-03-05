<?php
namespace Home\Controller;
use Think\Controller;
class SqlController extends Controller {
    public function index(){
       
        set_time_limit(0);
        $line = file_get_contents('a_all.txt');
        $line = unserialize($line);
        //线路
        /*foreach($line as $k => $val) {
            $line_insert = iconv('gbk', 'utf-8', $k);
            if (strpos($line_insert,'[上行') !== false) {
                $line_insert = substr($line_insert, 0,strpos( $line_insert,'[上行'));
                $data[] = ['city_id'=>218, 'line_name'=>$line_insert];
            }
        }
        M('line')->addAll($data);exit;*/
        //站点
       /* foreach($line as $k => $val) {
            $line_insert = iconv('gbk', 'utf-8', $k);
            if (strpos($line_insert,'[上行') !== false) {
                $line_insert = substr($line_insert, 0,strpos( $line_insert,'[上行'));
                $pp =  M('line')->where("line_name = '$line_insert'")->find();
                foreach ($val as $kk=>$vv){
                    $vv = iconv('gbk', 'utf-8', $vv);
                    $tmp = ['line_id'=>$pp['line_id'], 'station_name'=>$vv, 'sort' => $kk];
                    $data[] = $tmp;
                }
            }
        }
        var_dump(count($data));
        $line_id = M('station')->addAll($data);
        var_dump($line_id);*/
        /*var_dump($prv);exit;
        $city = M('city')->select();
        var_dump($city);exit;*/
        /*$prv = file_get_contents('p.txt');
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
        var_dump($city);exit;*/
    }
}