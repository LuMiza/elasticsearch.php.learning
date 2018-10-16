<?php

return [

    'elastic' => [
        '192.168.80.139:9200'
    ],
    'medoo' => [
        //必需mysql.exe -h120.79.212.4 -P3306 -uroot -p"O@o&WL1#zkpSXJGiqIHK"
        'database_type'=>'mysql',
        'database_name'=>'*',      //数据库名称
        'server'=>'*',        //数据库连接地址
        'username'=>'root',  //用户名
        'password'=>'*',  //密码
        'charset'=>'utf8',            //数据库编码
        // [可选的] 数据库连接端口
        'port'=> 3306,
        // [可选]表前缀
        'prefix'=>'',
        // [可选]用于连接的driver_option，阅读更多从http://www.php.net/manual/zh/pdo.setattribute.php
        'option'=> [
            PDO :: ATTR_CASE => PDO :: CASE_NATURAL
        ]
    ],


];