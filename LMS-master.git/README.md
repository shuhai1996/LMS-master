# LMS-master


1.在config/main.php开启url美化
   找到如下部分并修改
  'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,    // 这一步是将代码里链接的index.php隐藏掉。
            'rules'=>array(

                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),

2.apche服务器配置

<VirtualHost *:8088>
	ServerName localhost
	DocumentRoot C:\wamp64\www\LMS\code
	<Directory  "C:\wamp64\www\LMS\code">
		Options +Indexes +Includes +FollowSymLinks +MultiViews
		AllowOverride All
		Require all granted
	</Directory>
</VirtualHost>

另外要在code目录下添加.htaccess文件，写下如下代码

<IfModule rewrite_module>
    Options +FollowSymLinks
    IndexIgnore */*
    RewriteEngine On

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . index.php
</IfModule>

3.创建lms数据库，导入lms.sql文件