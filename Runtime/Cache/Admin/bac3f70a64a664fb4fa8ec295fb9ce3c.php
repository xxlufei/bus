<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/Public/Admin/css/base.css" />
	<link rel="stylesheet" href="/Public/Admin/css/login.css" />
	<title>公交信息查询系统</title>
</head>
<body>
	<div id="container">
		<div id="bd">
            <form action="/index.php/Admin/Public/index" method="post">
			<div class="login1" style="position: relative">
            	<div class="login-top"><label  style="font-size: 40px;color: white;font-style:italic;position: absolute; left:160px;top:62px;"><i>公交信息管理系统</i></label></div>
                <div class="login-input" style="position: relative">
                	<p class="user ue-clear">
                    	<label>用户名</label>
                        <input type="text" name="username"/>
                    </p>
                    <p class="password ue-clear">
                    	<label>密&nbsp;&nbsp;&nbsp;码</label>
                        <input type="password" name="password" />
                    </p>
                    <p class="yzm ue-clear">
                    	<label>验证码</label>
                        <input type="text" name="captcha" maxlength="4"/>
                        <div style="position: absolute; right:165px; top: 100px">
                            <img src="/index.php/Admin/Public/captcha" onclick="this.src='/index.php/Admin/Public/captcha/t/'+Math.random()" />
                        </div>
                    </p>
                </div>
                <div class="login-btn ue-clear">
                	<a href="javascript:;" id="btnlogin" class="btn">登录</a>
                </div>
            </div>
            </form>
		</div>
	</div>

</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript">
var height = $(window).height();
$("#container").height(height);
$("#bd").css("padding-top",height/2 - $("#bd").height()/2);

$(window).resize(function(){
	var height = $(window).height();
	$("#bd").css("padding-top",$(window).height()/2 - $("#bd").height()/2);
	$("#container").height(height);
	
});

$('#remember').focus(function(){
   $(this).blur();
});

$('#remember').click(function(e) {
	checkRemember($(this));
});

function checkRemember($this){
	if(!-[1,]){
		 if($this.prop("checked")){
			$this.parent().addClass('checked');
		}else{
			$this.parent().removeClass('checked');
		}
	}
}

//jquery form submit
$(function(){
    $('#btnlogin').on('click',function(){
        $('form').submit();
    });
});
</script>
</html>