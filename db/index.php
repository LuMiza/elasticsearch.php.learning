<?php
require '../loading.php';
header('Content-type:text/html;Charset=utf-8;');
$goods = new \Model\GoodsModel();

set_time_limit(0);
//dd($goods->createIndex());//创建索引
//$goods->setMapping();//创建映射
//$goods->insertAll(10);
exit;
$params = [
    'index' => 'shopping',
    'type'  => 'product',
    'body'  => [
        'query' => [
            'terms' => ['id' => [13841,13840]],
        ]
    ],
];

dd($goods->get(13841));
