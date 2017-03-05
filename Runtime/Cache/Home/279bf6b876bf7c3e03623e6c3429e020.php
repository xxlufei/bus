<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>公交查询</title>

    <!-- core CSS -->
    <link href="/Public/Home/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Home/css/font-awesome.min.css" rel="stylesheet">
    <link href="/Public/Home/css/prettyPhoto.css" rel="stylesheet">
    <link href="/Public/Home/css/animate.min.css" rel="stylesheet">
    <link href="/Public/Home/css/main.css" rel="stylesheet">
    <link href="/Public/Home/css/responsive.css" rel="stylesheet">
    <link href="/Public/Home/css/video-js.min.css" rel="stylesheet">
    <link href="/Public/Home/css/style.css" rel="stylesheet">
    <link href="/Public/Home/css/self.css" rel="stylesheet">
    <link href="/Public/Hplus/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/Hplus/css/plugins/jsTree/style.min.css" rel="stylesheet">
    <link href="/Public/Hplus/css/animate.min.css" rel="stylesheet">
    <link href="/Public/Hplus/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/Public/Home/js/html5shiv.js"></script>
    <script src="/Public/Home/js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="/Public/Home/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="/Public/Home/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="/Public/Home/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/Public/Home/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/Public/Home/images/ico/apple-touch-icon-57-precomposed.png">

    <script src="/Public/Home/js/jquery.js"></script>
    <script src="/Public/Home/js/bootstrap.min.js"></script>
    <script src="/Public/Home/js/jquery.prettyPhoto.js"></script>
    <script src="/Public/Home/js/jquery.isotope.min.js"></script>
    <script src="/Public/Home/js/main.js"></script>
    <script src="/Public/Home/js/wow.min.js"></script>
    <script src="/Public/Home/js/video.min.js"></script>
    <script src="/Public/Home/js/jquery.media.js"></script>
    <script src="/Public/Hplus/js/content.min.js?v=1.0.0"></script>
    <script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>

</head><!--/head-->
<body>
<header id="header">
    <nav class="navbar navbar-inverse" role="banner">
        <div class="container">
            <div class="navbar-header" style="width: 115px;height: 56px;">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><img src="/Public/Home/images/logo.png" alt="logo"></a>
            </div>

            <div class="collapse navbar-collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li><a href="\">首页</a></li>
                    <?php if($session["nickname"] != ''): ?><li><a href="<?php echo U('User/show');?>">个人中心</a></li>
                    <li><a href="<?php echo U('User/message');?>">留言板</a></li>
                    <li><a href="javascript:void(0)">　　　　　　　　　　　　　　　　　　　　　　　　</a></li>

                        <li><a href="javascript:void(0)">欢迎:<?php echo ($session["nickname"]); ?></a>|<a href="<?php echo U('Home/Index/logout');?>">注销</a></li>
                    <?php else: ?>
                        <li><a href="javascript:void(0)">　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　　</a></li>
                        <li><a href="<?php echo U('login');?>">登录</a>|<a href="register">注册</a></li><?php endif; ?>
                </ul>
            </div>
        </div><!--/.container-->
    </nav><!--/nav-->

</header><!--/header-->
<div class="container" id="cont1">

</div>
<script>
    console.log($('#header').height());
    console.log(window.screen.height )
    var h = window.screen.height-$('#header').height()
    $('#cont1').html('<iframe src="<?php echo U('tabs_panels');?>" scrolling="yes" id="iframe" name="iframe" width="100%" height="'+h+'" frameborder="0"></iframe>');
</script>