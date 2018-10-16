<?php

define('ROOT', str_replace('\\','/', __DIR__).'/');

include 'vendor/autoload.php';
require 'help/function.php';

require 'driver/inter/ElasticsearchCurd.class.php';

include 'driver/Elastic.class.php';
include 'driver/EsModel.class.php';

//model
require 'model/ArticlesModel.php';
require 'model/MemberModel.php';

