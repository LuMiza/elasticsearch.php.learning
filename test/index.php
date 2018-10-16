<?php
require '../loading.php';

$es = new \Model\MemberModel();

dd($es->getMapping('rumble'));

//$rest = db()->query('select * from cut_sku limit 10')->fetchAll(PDO::FETCH_ASSOC );
//dd($rest);