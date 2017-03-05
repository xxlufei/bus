<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="/Public/Admin/css/base.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/jquery.dialog.css" />
<link rel="stylesheet" href="/Public/Admin/css/index.css" />
<title>公交信息查询系统</title>
</head>

<body>
<div id="container">
  <div id="hd">
    <div class="hd-wrap ue-clear">
      <div class="top-light"></div>

      <div class="login-info ue-clear">
        <div class="welcome ue-clear"><?php echo (session('uname')); ?></div>
      </div>
      <div class="toolbar ue-clear"> <a href="<?php echo U('index');?>" class="home-btn">首页</a> <a href="javascript:;" class="quit-btn exit"></a> </div>
    </div>
  </div>
  <div id="bd">
    <div class="wrap ue-clear">
      <div class="sidebar">
        <h2 class="sidebar-header">
          <p>功能导航</p>
        </h2>
        <ul class="nav">
          <li class="office current">
            <div class="nav-header"><a href="javascript:;" date-src="/index.php/Admin/User/showList" class="ue-clear"><span>用户管理</span><i class="icon"></i></a></div>
          </li>
          <li class="gongwen">
            <div class="nav-header"><a href="javascript:;" date-src="/index.php/Admin/Message/showList" class="ue-clear"><span>留言管理</span><i class="icon"></i></a></div>
          </li>
          <li class="nav-info">
            <div class="nav-header"><a href="javascript:;" date-src="/index.php/Admin/Line/showList" class="ue-clear"><span>线路管理</span><i class="icon"></i></a></div>
          </li>
        </ul>
      </div>
      <div class="content">
        <iframe src="home.html" id="iframe" name="iframe" width="100%" height="100%" frameborder="0"></iframe>
      </div>
    </div>
  </div>
  <div id="ft" class="ue-clear">
    <div class="ft-left"> <span>公交查询系统</span>  </div>
    <div class="ft-right"> <span>© 1997-2015</span> <em></em> </div>
  </div>
</div>
<div class="exitDialog">
  <div class="dialog-content">
    <div class="ui-dialog-icon"></div>
    <div class="ui-dialog-text">
      <p class="dialog-content">你确定要退出系统？</p>
      <p class="tips">如果是请点击“确定”，否则点“取消”</p>
      <div class="buttons">
        <input type="button" class="button long2 ok" value="确定" />
        <input type="button" class="button long2 normal" value="取消" />
      </div>
    </div>
  </div>
</div>
</body>
<script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
<script type="text/javascript" src="/Public/Admin/js/common.js"></script>
<script type="text/javascript" src="/Public/Admin/js/core.js"></script>
<script type="text/javascript" src="/Public/Admin/js/jquery.dialog.js"></script>
<script type="text/javascript" src="/Public/Admin/js/index.js"></script>
</html>