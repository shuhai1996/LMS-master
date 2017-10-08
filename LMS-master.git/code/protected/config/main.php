<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
//

return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'recommend servise',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
        'application.modules.main.models.*',
        'application.modules.main.models.user.*',
        'application.modules.main.models.manage.*',
        'application.modules.main.models.reader.*',
    ),

    'modules'=>array(
         'main',
         'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123456',
            // 'ipFilters'=>array(...IP 列表...),
            // 'newFileMode'=>0666,
            // 'newDirMode'=>0777,
            ),
        ),

        // application components
        'components'=>array(
            // uncomment the following to enable URLs in path-format
           'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,    // 这一步是将代码里链接的index.php隐藏掉。
            'rules'=>array(
                'gii'=>'gii',
                'gii/<controller:\w+>'=>'gii/<controller>',
                'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
		

            // 其他业务功能数据库配置，可与后台数据配置相同
            // 'db'=>array(
            //       'connectionString' => 'mysql:host=127.0.0.1;dbname=lms',
            //     'emulatePrepare' => true,
            //     'username' => 'root',
            //     'password' =>'' ,
            //     'charset' => 'utf8',
            // ),
            
             'db'=>array(
                 'connectionString' => 'mysql:host=120.24.91.76;dbname=lms',
                'emulatePrepare' => true,
                'username' => 'admintolms',
                'password' =>'Admin2017' ,
                'charset' => 'utf8',
            ),


            //*** 后台数据库配置
            'db_frame'=>array(
                'class'=>'CDbConnection',
                 'connectionString' => 'mysql:host=120.24.91.76;dbname=lms',
                'emulatePrepare' => true,
                'username' => 'admintolms',
                'password' =>'Admin2017' ,
                'charset' => 'utf8',
            ),
            
            //    'db_frame'=>array(
            //     'class'=>'CDbConnection',
            //      'connectionString' => 'mysql:host=127.0.0.1;dbname=lms',
            //     'emulatePrepare' => true,
            //     'username' => 'root',
            //     'password' =>'' ,
            //     'charset' => 'utf8',
            // ),
            

           'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>YII_DEBUG ? null : 'site/error',
        ),
            'curl' => array(
                'class' => 'application.extensions.Curl',
                'options'=>array(
                    'timeout'=>60,
                    'setOptions'=>array(
                        CURLOPT_USERAGENT => 'open_zhushou/curl',
                    ),
                ),
            ),

            // 日志配置，日志在protected/runtime里面
            'log'=>array(
                'class'=>'CLogRouter',
                'routes'=>array(
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'trace, error, warning',
                    ),
                    array(
                        'class'=>'CFileLogRoute',
                        'levels'=>'info',
                        'logFile'=>'info.log',
                    ),
                ),
            ),
        ),

        // application-level parameters that can be accessed
        // using Yii::app()->params['paramName']
        'params'=>array(
            // 用户登陆开关，false不需要登陆所有用户可访问，但需要创建路由，true需要登录
            'close_user'=>false,
            'horizontal_menu_layout' => false, // 是否横向菜单
        ),
    );
