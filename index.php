<?php

ini_set('display_errors',1);
error_reporting(E_ERROR);

use common\components\Db;

define('ROOT', dirname(__FILE__));

// Composer
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$db = Db::getConnection();