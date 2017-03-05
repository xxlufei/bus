<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {

        //session('user', ['username'=>'ligoudan']);
        $session = session('user');
        //


        $this->assign(array(
            'session' => $session,
            'citys' => 123,
        ));
        $this->display();
    }

    //初始化数据
    public function tabs_panels()
    {
        $request = I();
        $current_prov_id = empty($request['current_prov_id']) ? 16 : $request['current_prov_id'];
        $province = M('province')->select();
        $citys = M('city')->where('province_id = ' . $current_prov_id)->select();
        $this->assign(array(
            'citys' => $citys,
            'json_citys' => json_encode($citys),
            'province' => $province,
            'current_prov_id' => $current_prov_id,
            'current_city_id' => $current_prov_id == 16 ? 218 : $citys[0]['city_id'],
        ));
//var_dump($citys);exit;
        $this->display();
    }

    public function city()
    {
        $request = I();
        $citys = M('city')->where('province_id = ' . $request['current_prov_id'])->select();
        echo json_encode($citys);
        return;
    }

    public function line()
    {
        $request = I();
        $lines = M('line')->where(['city_id' => $request['current_city_id']])->where('line_name like "%' . $request['line_name'] . '%"')->order('line_id asc')->select();
        if (!empty($lines)) {
            foreach ($lines as &$line) {
                $station = M('station')->where('line_id = ' . $line['line_id'])->order('sort asc')->select();
                $line['station'] = $station;
            }
        }
        //var_dump($lines);exit;
        echo json_encode($lines);
        return;
    }

    public function station()
    {
        $request = I();
        $stations = M('station')->where('station_name ="'. $request['station_name'].'"')->order('line_id asc')->select();
        $line_ids = array_column($stations, 'line_id');
        $line_ids = array_unique($line_ids);
        $map['line_id']  = array('IN', implode(',', $line_ids));
        $lines = M('line')->where($map)->select();
        if (!empty($lines)) {
            foreach ($lines as &$line) {
                $station = M('station')->where('line_id = ' . $line['line_id'])->order('sort asc')->select();
                $line['station'] = $station;
            }
        }
        echo json_encode($lines);
        return;
    }

    public function stationA_to_stationB()
    {

        $request = I();
        //直达线路,经过 A的线路 与 经过B 的线路交集
        $stationsA = M('station')->where('station_name ="'. $request['station_name_A'].'"')->order('line_id asc')->select();
        $stationsB = M('station')->where('station_name ="'. $request['station_name_B'].'"')->order('line_id asc')->select();
        if (empty($stationsA)) {
            echo 1;return;
        }
        if (empty($stationsB)) {
            echo 2;return;
        }
        $data = $this->direct($stationsA, $stationsB);
        foreach ($data['direct_line'] as &$di) {
            $di['A'] = $request['station_name_A'];
            $di['B'] = $request['station_name_B'];
        }
        $final_line['direct'] = $data['direct_line'];
        //直达查询完毕
        /*换乘
            站点A所在的全部线路上的全部站点

            站点B所在的全部线路上的全部站点

            交集

            即为换乘站点
        */

        unset($stationsA);
        unset($stationsB);
        $line_idsA = $data['line_idsA'];
        $line_idsB = $data['line_idsB'];
        $direct_line_ids = $data['direct_line_ids'];
        $mapA['line_id']  = array('IN', implode(',', array_diff($line_idsA, $direct_line_ids)));//经过A的全部线路(不包括AB直达线路)
        $mapB['line_id']  = array('IN', implode(',', array_diff($line_idsB, $direct_line_ids)));//经过B的全部线路(不包括AB直达线路)
        $stationsA = M('station')->where($mapA)->select();//经过A的全部站点
        $stationsB = M('station')->where($mapB)->select();//经过B的全部站点
        $transfer_station = array();
        foreach ($stationsA as $stationA) {
            foreach ($stationsB as $stationB) {
                if ($stationB['station_name'] == $stationA['station_name']) {
                    //同一条线路只记录一个中转站  && 已存在的中转站不重复记录
                    if (!$this->deep_in_array($stationB['line_id'], $transfer_station) && !$this->deep_in_array($stationB['station_name'], $transfer_station)) {
                        $transfer_station[] = $stationB;
                    }
                }
            }
        }
        //取出A到中转站的全部直达线路
        $data_line = array();
        foreach ($transfer_station as $trans) {
            $stations_trans = M('station')->where('station_name ="'. $trans['station_name'].'"')->order('line_id asc')->select();
            $tmp_data_a = $this->direct($stationsA, $stations_trans);
            $data_line['a_to_trans'] = implode('或',array_column($tmp_data_a['direct_line'], 'line_name'));
            $data_line['transfer_station'] = $trans['station_name'];
            $tmp_data_b = $this->direct($stationsB, $stations_trans);
            $data_line['trans_to_b'] = implode('或',array_column($tmp_data_b['direct_line'], 'line_name'));

            $str = array_merge(range(0,9),range('a','z'),range('A','Z'));
            shuffle($str);
            $str = implode('',array_slice($str,0,15));
            $data_line['id'] = $str;
            $data_line['A'] = $request['station_name_A'];
            $data_line['B'] = $request['station_name_B'];

            $final_trans[] = $data_line;
        }

        $final_line['trans'] =  $final_trans;
        //dump($final_line);exit;
        echo json_encode($final_line);
        return;
    }

    protected function direct($stationsA, $stationsB)
    {
        $direct_line = array();
        $line_idsA = array_column($stationsA, 'line_id');
        $line_idsA = array_unique($line_idsA);//经过A点的线路ids
        $line_idsB = array_column($stationsB, 'line_id');
        $line_idsB = array_unique($line_idsB);//经过B点的线路ids
        $direct_line_ids = array_intersect($line_idsA, $line_idsB);//$line_idsA 、$line_idsB交集即为直达线路ids
        if (!empty($direct_line_ids)) {
            $map_direct['line_id']  = array('IN', implode(',', $direct_line_ids));
            $direct_line = M('line')->where($map_direct)->select();
            foreach ($direct_line as &$direct_l) {
                $station = M('station')->where('line_id = ' . $direct_l['line_id'])->order('sort asc')->select();
                $direct_l['station'] = $station;
            }
            unset($station);
        }
        $data['direct_line_ids'] = $direct_line_ids;
        $data['line_idsA'] = $line_idsA;
        $data['line_idsB'] = $line_idsB;
        $data['direct_line'] = $direct_line;

        return $data;//直达线路及线路站点
    }

    protected function deep_in_array($value, $array) {
        foreach($array as $item) {
            if(!is_array($item)) {
                if ($item == $value) {
                    return true;
                } else {
                    continue;
                }
            }

            if(in_array($value, $item)) {
                return true;
            } else if($this->deep_in_array($value, $item)) {
                return true;
            }
        }
        return false;
    }

    public function login()
    {
        $post = I('post.');
        if (!empty($post)) {
            # 验证码成功,执行实例化模型查询数据操作
            $model = D('users');
            # 获取提交表单信息后与实例化user表中的username password对比
            $result = $model->where(array(
                'username' => $post['username'],
                'password' => md5($post['password']),
            ))->find();
            if ($result) {
                # 持久化
                session('user', $result);
                echo json_encode(['dec' => ['code' => 200000]]);
                return;
                //$this->success('登录成功！', U('Index/index'), 3);
            } else {
                # 用户名或密码错误
                echo json_encode(['dec' => ['code' => 100000, 'msg' => '用户名或密码错误!']]);
                return;
            }
        } else {
            $this->display();
        }
    }

    #logout
    public function logout()
    {
        session(null);
        $this->success('退出成功', U('index'), 3);
    }

    public function register()
    {

        $post = I('post.');
        if (!empty($post)) {
            # 验证码成功,执行实例化模型查询数据操作
            $model = D('users');
            if ($post['pwd'] !== $post['repwd']) {
                echo json_encode(['dec' => ['code' => 100000], 'msg' => '两次输入的密码不一致']);
                return;
            }
            # 获取提交表单信息后与实例化user表中的username password对比
            $data = ['username' => $post['email'], 'password' => md5($post['pwd']), 'nickname' => $post['nickname']];
            $id = $model->add($data);
            if ($id) {
                # 持久化
                session('user', $data);
                echo json_encode(['dec' => ['code' => 200000]]);
                return;
                //$this->success('登录成功！', U('Index/index'), 3);
            } else {
                # 用户名或密码错误
                echo json_encode(['dec' => ['code' => 100000]]);
                return;

            }
        } else {
            $this->display();
        }
    }
}