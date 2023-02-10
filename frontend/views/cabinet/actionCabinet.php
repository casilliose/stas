<?php
require_once('../../../index.php');

$dir = '../../../uploads';
$files = scandir($dir);
$files = array_slice($files, 2);

require_once('cabinet.php');