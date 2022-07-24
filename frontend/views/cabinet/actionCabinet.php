<?php
require_once('../../../index.php');

use common\models\FileStorageItem;

$files = FileStorageItem::getFileNames();

require_once('cabinet.php');