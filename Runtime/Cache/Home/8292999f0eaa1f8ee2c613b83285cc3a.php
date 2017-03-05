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
<section id="blog" class="container">
    <div class="blog">
        <div class="wrapper wrapper-content  animated fadeInRight">

            <div class="row">
                <div class="col-sm-12">

                    <div class="ibox chat-view">
                        <div class="ibox-content">

                            <div class="row">

                                <div class="col-md-12 ">
                                    <div class="chat-discussion">

                                        <?php if(is_array($messages)): $i = 0; $__LIST__ = $messages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$message): $mod = ($i % 2 );++$i;?><div class="chat-message">
                                            <img class="message-avatar" src="/Public/Home/images/blog/avatar3.png" alt="">
                                            <div class="message">
                                                <a class="message-author" href="#"> 我</a>
                                                <span class="message-date"> <?php echo (date('Y-m-d H:i:s',$message["create_at"])); ?> </span>
                                                <span class="message-content">
											<?php echo ($message["content"]); ?>
                                            </span>
                                            </div>
                                        </div>
                                            <?php if($message["reply"] != ''): ?><div class="chat-message">
                                            <img class="message-avatar" src="/Public/Home/images/blog/avatar1.png" alt="">
                                            <div class="message">
                                                <a class="message-author" href="#"> 系统管理员 </a>
                                                <span class="message-date">  <?php echo (date('Y-m-d H:i:s',$message["reply_at"])); ?> </span>
                                                <span class="message-content">
											<?php echo ($message["reply"]); ?>
                                            </span>
                                            </div>
                                        </div>
                                                <?php else: ?>
                                                <div class="chat-message">
                                                    <img class="message-avatar" src="/Public/Home/images/blog/avatar1.png" alt="">
                                                    <div class="message">
                                                        <a class="message-author" href="#"> 系统管理员 </a>

                                                        <span class="message-content">
											本条留言尚未得到回复
                                            </span>
                                                    </div>
                                                </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>

                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="chat-message-form">

                                        <div class="form-group">

                                            <textarea id="txt3" class="form-control message-input" name="message" placeholder="输入留言内容"></textarea>
                                            <div id="div3">发表</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!--/#blog-->
<script>
    $(function () {
        $("#div3").click(function () {
            var val = $("#txt3").val();

                $.post("<?php echo U('add_message');?>", {content: val, user_id:<?php echo ($session["user_id"]); ?>}, function (result) {
console.log(result)
                    if (result != 200000) {
                        alert('留言失败');
                    } else {
                        alert('留言成功');
                        window.location.href = 'message';
                    }
                });
            });

        });
</script>
@include('footer');