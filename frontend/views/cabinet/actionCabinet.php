<?php
require_once('../../../index.php');

use common\models\FileStorageItem;
use common\models\User;

$userId = User::checkLogged() ?? null;

if (empty($userId)) {
    header('Location: /frontend/views/user/login.php');
}

$files = FileStorageItem::getFileNamesByUserId($userId);

require_once('cabinet.php');