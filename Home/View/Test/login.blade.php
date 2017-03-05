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
		<script src="front/js/bootstrap.min.js"></script>
		<script src="admin/vendor/angular/angular.js"></script>
		<script src="admin/vendor/jquery/jquery.form.js"></script>
		<style type="text/css">
			body{background: url(front/images/login.jpg) no-repeat;background-size: cover;font-size: 16px;}
			.form{background: rgba(255,255,255,0.2);width:400px;margin:100px auto;}
			#login_form{display: block;}
			#register_form{display: none;}
			.fa{display: inline-block;top: 27px;left: 6px;position: relative;color: #ccc;}
			input[type="text"],input[type="password"]{padding-left:26px;}
			.checkbox{padding-left:21px;}
		</style>
	</head>
	<body>
	<div class="container">
		<div class="form row">
			<form role="form" ng-app="myApp" ng-controller="validateCtrl"
				  name="myForm" class="form-horizontal col-sm-offset-3 col-md-offset-3" id="login_form" method="post">
				<h3 class="form-title">登录</h3>
				<div class="col-sm-9 col-md-9">
					<div class="form-group">
						<i class="fa fa-user fa-lg"></i>
						<input class="form-control required" type="text" ng-model="username" placeholder="Username" name="username" autofocus="autofocus" required/>
					</div>
					<div class="form-group">
							<i class="fa fa-lock fa-lg"></i>
							<input class="form-control required" ng-model="password" type="password" placeholder="Password" name="password" required/>
					</div>
					<div class="form-group">

						<hr />
						<a href="register" id="register_btn" class="">没有账号?点击注册</a>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success pull-right" ng-click="login()"
								ng-disabled="myForm.username.$invalid || myForm.password.$invalid || formcheck" id="register_submit_btn">提交</button>
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
		$scope.btn_click = function () {
			$scope.formcheck = false;
		}
		$scope.formcheck = false;
		$scope.login = function() {
			$scope.formcheck = true;
			$("#login_form").ajaxSubmit({
				url: "login",
				dataType: 'json',
				async: true,
				success: function (response) {
					if (response.dec.code!="200000" ) {
						$scope.formcheck = false;
						$("#button_click").click();
						alert(response.dec.msg);
					}else {
						alert('登录成功');
						window.location.href='{{'http://work.lcode.cc/'.$root_url}}';
					}
				}
			})
		};
	});
</script>