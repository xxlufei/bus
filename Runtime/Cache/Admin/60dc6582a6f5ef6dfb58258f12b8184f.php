<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Public/Hplus/css/bootstrap.min14ed.css" rel="stylesheet">
    <link href="/Public/Hplus/css/font-awesome.min93e3.css" rel="stylesheet">
    <link href="/Public/Hplus/css/animate.min.css" rel="stylesheet">
    <link href="/Public/Hplus/css/style.min862f.css" rel="stylesheet">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-mgt.css" />
<link rel="stylesheet" href="/Public/Admin/css/WdatePicker.css" />
<title>公交信息查询系统</title>
<style type='text/css'>
	table tr .id{ width:63px; text-align: center;}
	table tr .name{ width:118px; padding-left:17px;}
	table tr .nickname{ width:63px; padding-left:17px;}
	table tr .dept_id{ width:63px; padding-left:13px;}
	table tr .sex{ width:63px; padding-left:13px;}
	table tr .birthday{ width:80px; padding-left:13px;}
	table tr .tel{ width:113px; padding-left:13px;}
	table tr .email{ width:160px; padding-left:13px;}
	table tr .addtime{ width:160px; padding-left:13px;}
	table tr .operate{ padding-left:13px;}
</style>
</head>

<body>
<div class="title"  style="height: 33px;"><h2 style="margin-top: 8px;">线路管理</h2></div>
<div class="table-operate ue-clear row">
    <div class="col col-lg-2">
        <div class="row">
            <div class="col-lg-2">
                <a href="javascript:;" class="del m-l-sm" id="btndel">删除</a>
            </div>
            <div class="col-lg-2 m-l-md">
                <div class="wrapper  animated fadeInRight">
                    <button type="button" class="add btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">
                        增加线路
                    </button>

                    <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <i class="fa fa-laptop modal-icon"></i>
                                    <h4 class="modal-title">增加线路</h4>
                                </div>
                                <form action="/index.php/Admin/Line/add" method="post">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row m-l-n-xs">
                                                <label class="h4">线路名：</label>
                                                <input type="text" name="line_name" class="form-control m-l-xs h5" placeholder="请输入线路名">
                                            </div>
                                            <div class="row m-l-n-xs" >
                                                <label class="h4 m-b-n-md">站点：</label>
                                                <textarea name="station" cols="30" rows="10"
                                                          class="form-control h4" placeholder="请添加站点"></textarea>
                                                <input type="hidden" name="line_id" value="<?php echo ($vol["line_id"]); ?>">
                                                <input type="hidden" name="city_id" value="<?php echo ($current_city); ?>">
                                                <label class="text-danger h4">注:站点名之间请以半角分号";"隔开</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                                        <input type="submit" value="提交" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>

    <div class="col">
        <label class="h5">请选择城市：</label>
        <select name="city" class="select" id="city">
            <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["city_id"]); ?>" <?php if($v["city_id"] == $current_city): ?>selected<?php endif; ?>><?php echo ($v["city_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="id">序号</th>
                <th class="name">线路名称</th>
				<th class="nickname">线路编辑</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
            	<td class="id"><?php echo ($vol["line_id"]); ?></td>
                <td class="name"><?php echo ($vol["line_name"]); ?></td>
				<td class="nickname">

                    <div class="wrapper wrapper-content  animated fadeInRight">

                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal1">
                                点击编辑
                            </button>

                            <div class="modal inmodal" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <i class="fa fa-laptop modal-icon"></i>
                                            <h4 class="modal-title">线路编辑</h4>
                                        </div>
                                        <form action="/index.php/Admin/Line/update" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <div class="row m-l-n-xs">
                                                    <label class="h4">线路名：</label>
                                                    <input type="text" name="line_name" class="form-control m-l-xs h5" value="<?php echo ($vol["line_name"]); ?>">
                                                    </div>
                                                    <div class="row m-l-n-xs" >
                                                        <label class="h4 m-b-n-md">站点：</label>
                            <textarea name="station" id="" cols="30" rows="10"
                                      class="form-control h4"><?php echo ($vol["station"]); ?></textarea>
                                                    <input type="hidden" name="line_id" value="<?php echo ($vol["line_id"]); ?>">
                                                        <label class="text-danger h4">注:站点名之间请以半角分号";"隔开</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                                                <input type="submit" value="提交" class="btn btn-primary">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>

                </td>
                <td class="operate">
                    <input type="checkbox" value="<?php echo ($vol["line_id"]); ?>" />
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="pagination ue-clear">
	<div class="pagin-list">
		<?php echo ($page); ?>
	</div>
	<div class="pxofy">显示第 1 条到 10 条记录，总共<?php echo ($count); ?>条记录</div>
</div>
</body>
<script src="/Public/Hplus/js/jquery.min.js"></script>
<script src="/Public/Hplus/js/bootstrap.min.js"></script>
<script src="/Public/Hplus/js/content.min.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
<script type="text/javascript">
    $('#city').on('change', function(){
        window.location.href="/index.php/Admin/Line/showList?city_id="+$('#city').val();
    })
    //delbutton
    $('#btndel').on('click', function(){
        var id = $(':checkbox:checked');
        var ids = "";
        for (var i = 0; i < id.length; i ++) {
            ids = ids + id[i].value + ",";
        }
        ids = ids.substring(0, ids.length - 1);
        window.location.href = "/index.php/Admin/Line/del/ids/" + ids;
    });
</script>
</html>