<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

/*// 定义应用目录
define('APP_PATH','./Application/');*/

//设置字符集
header('Content-Type:text/html;charset=utf-8');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);

// 定义当前文件所在的工作目录
define('WORKING_PATH', str_replace('\\', '/', __DIR__));

// 定义上传文件的根目录（相对站点的根目录）
define('UPLOAD_ROOT_PATH', '/Public/Upload/');

//控制目录安全文件的开关
define('BUILD_DIR_SECURE', false);//默认为true，表示开启自动生成目录安全文件
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单