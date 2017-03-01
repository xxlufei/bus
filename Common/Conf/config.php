<?php
return array(
	// '配置项'=>'配置值'

    // 模块比对列表
    'MODULE_ALLOW_LIST' => array('Home', 'Admin'),

    // 数据库设置
    'DB_TYPE'           =>  'mysql',     // 数据库类型
    'DB_HOST'           =>  'localhost', // 服务器地址
    'DB_NAME'           =>  'db_oa',          // 数据库名
    'DB_USER'           =>  'root',      // 用户名
    'DB_PWD'            =>  'mx3191006',          // 密码
    'DB_PORT'           =>  '3306',        // 端口
    'DB_PREFIX'         =>  'tp_',    // 数据库表前缀

    // 显示跟踪信息
    'SHOW_PAGE_TRACE' => true,

    // 字段反向映射
    // READ_DATA_MAP主配置文件中不存在，需要自行配置
    // 默认为false，不进行映射，还有另外的反向映射方法，Model中parseFieldsMap()方法
    'READ_DATA_MAP' => true,

    // 应用层级配置动态加载自定义外部文件
    // 该配置项在主配置文件中是不存在的，需要自行定义
    'LOAD_EXT_FILE' => 'phpinfo',

    // RBAC权限控制
    'RBAC_ROLES' => array(
        1        => '高层领导',
        2        => '中层领导',
        3        => '普通职员',
    ),

    // 权限数组
    'RBAC_AUTHS'    => array(
        'auth1'     => array('*/*'),
        'auth2'     => array('email/*','knowledge/*'),
        'auth3'     => array('email/*'),
    ),

);