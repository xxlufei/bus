<?php
/**
 * Created by PhpStorm.
 * User: ihere
 * Date: 2017/3/2
 * Time: 10:02
 */

namespace Admin\Controller;


use Think\Page;

class LineController extends CommonController
{
    public function showList()
    {
        $model = D('line');

        $city_id = empty(I('city_id')) ? 218 : I('city_id');
        # 查询总记录数，用于分页
        $count = $model->where(['city_id' => $city_id])->count();
        # 实例化分页类并且将count数值、每页显示信息数传值
        $page = new Page($count, 10, ['city_id' => $city_id]);
        # 可选 进行分页信息的配置
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $page->setConfig('first','首页');
        $page->setConfig('last','末页');
        $page->lastSuffix = false;
        # 生成页面等信息
        $show = $page->show();
        # limit 查询结果
        $data = $model->where(['city_id' => $city_id])->limit($page->firstRow,$page->listRows)->field('line_id, line_name')->select();
        $city = M('city')->select();
        $line_ids = array_column($data, 'line_id');
        $line_ids = implode(',', $line_ids);
        $map['line_id']  = array('IN',$line_ids);
        $station = M('station')->where($map)->order('line_id asc, sort asc')->select();
        foreach ($data as &$d) {
            foreach ($station as $sta) {
                if ($sta['line_id'] == $d['line_id']) {
                    $tmp_arr[] = $sta['station_name'];
                }
            }
            $d['station'] = implode(';', $tmp_arr);
            unset($tmp_arr);
        }
        $this->assign(array(
            'data' => $data,
            'city' => $city,
            'current_city' => $city_id,
            'page' => $show,
            'count' => $count,
        ));
        $this->display();
    }

    public function update()
    {
        $post = I();
        if (strpos($post['station'], '；') !== false) $this->error('站点名之间只接受半角分号,请切换输入法为英文后输入分号', U('showList'), 3);
        if (empty($post['line_id'])) $this->error('参数错误', U('showList'), 3);
        $req_station = explode(';', $post['station']);
        $station = array();
        foreach ($req_station as $sta) {
            if (!empty($sta)) {
                $sta = str_replace(' ', '', $sta);
                $station[] = $sta;
            }
        }
        foreach ($station as $kk=>$vv){
            $data[] = ['line_id'=>$post['line_id'], 'station_name'=>$vv, 'sort' => $kk];
        }
        $obj_station = M('station');
        $obj_station->startTrans();
        $obj_station->where('line_id = '.$post['line_id'])->delete();
        M('line')->where('line_id = '.$post['line_id'])->save(['line_name'=>$post['line_name']]);
        if ($obj_station->addAll($data)) {
            $obj_station->commit();
            $this->success('操作成功', U('showList'), 3);
        } else {
            $obj_station->rollback();
            $this->error('操作失败', U('showList'), 3);
        }
    }

    public function add()
    {
        $post = I();
        if (strpos($post['station'], '；') !== false) $this->error('站点名之间只接受半角分号,请切换输入法为英文后输入分号', U('showList'), 3);
        $req_station = explode(';', $post['station']);
        $station = array();
        foreach ($req_station as $sta) {
            if (!empty($sta)) {
                $sta = str_replace(' ', '', $sta);
                $station[] = $sta;
            }
        }
        $post['line_id'] = M('line')->add(['line_name'=>$post['line_name'], 'city_id' => $post['city_id']]);
        foreach ($station as $kk=>$vv){
            $data[] = ['line_id'=>$post['line_id'], 'station_name'=>$vv, 'sort' => $kk];
        }
        $obj_station = M('station');
        if ($obj_station->addAll($data)) {
            $this->success('操作成功', U('showList')."?city_id={$post['city_id']}", 3);
        } else {
            $this->error('操作失败', U('showList')."?city_id={$post['city_id']}", 3);
        }
    }

    # 删除并跳转
    public function del()
    {
        $ids = I('get.ids');
        $line_ids = explode(',', $ids);
        $map['line_id']  = array('IN', $line_ids);
        # 实例化
        $model = M('line');
        $model->startTrans();
        $rst = M('line')->delete($ids);
        $rst1 = M('station')->where($map)->delete();
        if ($rst && $rst1) {
            $model->commit();
            $this->success('删除成功', U('showList'), 3);
        } else {
            $model->rollback();
            $this->error('删除失败', U('showList'), 3);
        }
    }
}