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
<div class="title"  style="height: 33px;"><h2 style="margin-top: 8px;">留言管理</h2></div>
<div class="table-operate ue-clear">
    <a href="javascript:;" class="del" id="btndel">删除</a>
</div>
<div class="table-box">
	<table>
    	<thead>
        	<tr>
            	<th class="id">序号</th>
                <th class="name">用户名</th>
				<th class="nickname">留言内容</th>
				<th class="nickname">回复</th>
                <th class="operate">操作</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><tr>
            	<td class="id"><?php echo ($vol["message_id"]); ?></td>
                <td class="name"><?php echo ($vol["nickname"]); ?></td>
				<td class="nickname"><?php echo ($vol["content"]); ?></td>
				<td class="nickname">
                    <?php if($vol["reply"] == ''): ?><div class="wrapper wrapper-content  animated fadeInRight">

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                回复
                            </button>

                            <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated bounceInRight">
                                        <div class="modal-header">
                                            <i class="fa fa-laptop modal-icon"></i>
                                            <h4 class="modal-title">回复留言</h4>
                                        </div>
                                        <form action="/index.php/Admin/Message/reply" method="post">
                                            <div class="modal-body">
                                                <div class="form-group">
                            <textarea name="reply" id="" placeholder="请输入回复内容" cols="30" rows="10"
                                      class="form-control"></textarea>
                                                    <input type="hidden" name="message_id" value="<?php echo ($vol["message_id"]); ?>">
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
                        <?php else: ?> <?php echo ($vol["reply"]); endif; ?>
                </td>
                <td class="operate">
                    <input type="checkbox" value="<?php echo ($vol["message_id"]); ?>" />
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
$(".select-title").on("click",function(){
	$(".select-list").hide();
	$(this).siblings($(".select-list")).show();
	return false;
})
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(this).parent($(".select-list")).siblings($(".select-title")).find("span").text(txt);
})

// $('.pagination').pagination(100,{
// 	callback: function(page){
// 		alert(page);	
// 	},
// 	display_msg: true,
// 	setPageNo: true
// });

$("tbody").find("tr:odd").css("backgroundColor","#eff6fa");

showRemind('input[type=text], textarea','placeholder');

//编辑按钮功能
    $(function(){

        $('#btndel').on('click',function(){
           var id =  $(':checkbox:checked');//jQuery对象，类数组对象
            var ids = "";
            for (var i = 0; i < id.length; i ++) {
                ids = ids + id[i].value + ",";//连接字符串
            }
            ids = ids.substring(0, ids.length - 1);
            window.location.href = "/index.php/Admin/Message/del/id/" + ids;
        });

    });
</script>
</html>