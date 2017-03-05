<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>公交查询</title>
	<!--用百度的静态资源库的cdn安装bootstrap环境-->
	<!-- Bootstrap 核心 CSS 文件 -->
	<link href="front/css/bootstrap.min.css" rel="stylesheet">
	<!--font-awesome 核心我CSS 文件-->
	<link href="front/css/font-awesome.min.css" rel="stylesheet">
	<!-- 在bootstrap.min.js 之前引入 -->
	<script src="front/js/jquery.min.js"></script>
	<!-- Bootstrap 核心 JavaScript 文件 -->
	<script src="admin/vendor/angular/angular.js"></script>
	<script src="admin/vendor/jquery/jquery.form.js"></script>
	<style type="text/css">
		body{background: url(front/images/login.jpg) no-repeat;background-size: cover;font-size: 16px;}
		.form{background: rgba(255,255,255,0.2);width:400px;margin:100px auto;}
		.fa{display: inline-block;top: 27px;left: 6px;position: relative;color: #ccc;}
		input[type="text"],input[type="password"]{padding-left:26px;}
		.checkbox{padding-left:21px;}
	</style>
</head>
<body>
<div class="container">
	<div class="form row">
		<form role="form" ng-app="myApp" ng-controller="validateCtrl"
			  name="myForm" class="form-horizontal col-sm-offset-3 col-md-offset-3" id="register_form" enctype="multipart/form-data" method="post">
			<h3 class="form-title">注册</h3>
			<div class="col-sm-9 col-md-9">
				<div class="form-group">
					<i class="fa fa-user fa-lg"></i>
					<input class="form-control" style="padding-left: 26px" type="email" name="email" ng-model="email" placeholder="请输入邮箱" required>
					<span style="color:red" ng-show="myForm.email.$dirty && myForm.email.$invalid">
						<span ng-show="myForm.email.$error.required">邮箱是必须的。</span>
						<span ng-show="myForm.email.$error.email">非法的邮箱地址。</span>
					</span>
				</div>
				<div class="form-group">
					<i class="fa fa-lock fa-lg"></i>
					<input type="password" class="form-control" ng-model="pwd" ng-minlength="6" ng-maxlength="20" name="pwd" id="password" placeholder="请输入密码..." required>
					<span style="color: red" ng-show="myForm.pwd.$invalid">
                        <span ng-show="myForm.pwd.$error.minlength">*密码长度不小于6</span>
                        <span ng-show="myForm.pwd.$error.maxlength">*密码长度不能超过20</span>
                    </span>
				</div>
				<div class="form-group">
					<i class="fa fa-lock fa-lg"></i>
					<input type="password" class="form-control" ng-model="repwd" name="repwd" id="repwd" placeholder="请再输一遍密码..." required>
					<span style="color: red" ng-show="myForm.repwd.$dirty && myForm.pwd.$valid">
                        <span ng-show="repwd!=pwd">两次密码输入不一致</span>
                    </span>
				</div>
				<div class="form-group">
					<i class="fa fa-pencil fa-lg"></i>
					<input class="form-control" type="text" placeholder="请填写昵称" ng-model="nickname" name="nickname" maxlength="8" required>
					<span style="color:red" ng-show="myForm.nickname.$dirty && myForm.nickname.$invalid">
						<span ng-show="myForm.nickname.$error.required">昵称是必须的。</span>
					</span>
				</div>
				<div class="form-group" style="position:relative;">
					{{--<input id="lefile" type="file" class="form-control"　name="avatar" ng-show="false">
					<div class="input-append">--}}
					<i class="fa fa-md" style="color:darkorange">头像</i>
					<div class="form-control">
						<input id="photoCover" style="margin-left: 36px"  type="file" style="height:30px;" name="avatar">
					</div>
						{{--<span class="btn btn-primary pull-right" style="position:absolute;top:0px;right: 0px" onclick="$('input[id=lefile]').click();">Browse</span>
					</div>--}}
				</div>
				<div class="form-group">
					<button ng-click="return_login()" class="btn btn-primary btn-tiny pull-left">返回登录</button>
					<button type="submit" class="btn btn-success pull-right" ng-click="regist()"
							ng-disabled="myForm.email.$invalid || myForm.nickname.$invalid || myForm.password.$invalid || pwd != repwd || formcheck" id="register_submit_btn">提交</button>
					<button id="button_click" ng-click="btn_click()" ng-show="false">提交</button>
				</div>
			</div>
		</form>
	</div>
</div>
</body>
</html>
<script>
	var app = angular.module('myApp', []);
	app.controller('validateCtrl', function($scope) {
		$scope.return_login = function(){
			window.location.href='login';
		}
		$scope.btn_click = function () {
			$scope.formcheck = false;
		}
		$scope.formcheck = false;
		$scope.regist = function() {
			$scope.formcheck = true;
			$("#register_form").ajaxSubmit({
				url: "register",
				dataType: 'json',
				async: true,
				success: function (response) {
					if (response.dec.code!="200000" ) {
						$scope.formcheck = false;
						$("#button_click").click();
						alert(response.dec.msg);
					}else {
						alert('注册成功');
						window.location.href='{{'http://work.lcode.cc/'.$root_url}}';
					}
				}
			})
		};
	});
</script>
<script type="text/javascript">
	$('input[id=lefile]').change(function() {
		var file = $(this).val();
		var pos=file.lastIndexOf("\\");
		var fileName = file.substring(pos+1);
		$('#photoCover').val(fileName);
	});
</script>
