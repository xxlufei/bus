<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" href="/Public/Admin/css/info-reg.css" />
<link href="/Public/Admin/ueditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/Admin/ueditor/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/Admin/ueditor/lang/zh-cn/zh-cn.js"></script>
<title>移动办公自动化系统</title>
<style type='text/css'>
	select {
		background: rgba(0, 0, 0, 0) url("/Public/Admin/images/inputbg.png") repeat-x scroll 0 0;
	    border: 1px solid #c5d6e0;
	    height: 28px;
	    outline: medium none;
	    padding: 0 8px;
	    width: 240px;
	}
	.main p input {
		float:none;
	}
</style>
</head>

<body>
<div class="title"><h2>公文起草</h2></div>
<form action="/index.php/Admin/Doc/addOk" method="post" enctype="multipart/form-data">
<div class="main">
	<p class="short-input ue-clear">
    	<label>标题：</label>
        <input name="title" type="text" placeholder="标题..." />
    </p>
	<p class="short-input ue-clear">
    	<label>附件：</label>
        <input name="file" type="file"/>
    </p>
    <p class="short-input ue-clear">
    	<label>作者：</label>
        <input name="author" type="text" placeholder="作者..." />
    </p>
    <p class="short-input ue-clear">
    	<label>内容：
            <!--style给定宽度可以影响编辑器的最终宽度-->
            <script type="text/plain" id="myEditor" style="width:1000px;height:240px;" name="content">
            <p>这里我可以写一些输入提示</p>
            </script>
        </label>

    </p>
</div>
<div class="btn ue-clear">
	<a href="javascript:;" class="confirm" id='btnSubmit'>确定</a>
    <a href="javascript:;" class="clear" id='btnReset'>清空内容</a>
</div>
</form>
</body>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/WdatePicker.js"></script>
<script type="text/javascript">
$(function(){
	$('#btnSubmit').on('click',function(){
		$('form').submit();
	});
	
	$('#btnReset').on('click',function(){
		$('form')[0].reset();
	});
});	

$(".select-title").on("click",function(){
	$(".select-list").toggle();
	return false;
});
$(".select-list").on("click","li",function(){
	var txt = $(this).text();
	$(".select-title").find("span").text(txt);
});
showRemind('input[type=text], textarea','placeholder');

//实例化编辑器
var um = UM.getEditor('myEditor');
um.addListener('blur',function(){
    $('#focush2').html('编辑器失去焦点了')
});
um.addListener('focus',function(){
    $('#focush2').html('')
});
</script>
</html>