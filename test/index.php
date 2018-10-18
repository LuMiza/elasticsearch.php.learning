<?php
require '../loading.php';
header('Content-type:text/html;Charset=utf-8;');
$es = new \Model\MemberModel();

//dd($es->getMapping('rumble'));

//$rest = db()->query('select * from cut_sku limit 10')->fetchAll(PDO::FETCH_ASSOC );
//dd($rest);

//$result = \help\Http::curlPost('http://192.168.80.139:9200/_search', '{"query":{"match_all":{}}}');
//dd(json_decode($result,true));
$data = [
    'query' => [
        'match_all' => [],
    ],
];
$result = \help\Http::curl('http://192.168.80.139:9200/_search','post', json_encode($data, JSON_FORCE_OBJECT));
dd($result);

//$result =  \help\Http::curlGet('http://192.168.80.139:9200/_cluster/health?pretty=true');
//dd(json_decode($result,true));
