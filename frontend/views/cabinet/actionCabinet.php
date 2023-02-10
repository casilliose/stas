<?php
require_once('../../../index.php');

use common\models\FileStorageItem;
use common\models\User;

$userId = User::checkLogged() ?? null;
$files = FileStorageItem::getFileNamesByUserId($userId);

require_once('cabinet.php');