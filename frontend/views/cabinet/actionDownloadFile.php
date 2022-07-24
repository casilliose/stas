<?php

require_once('../../../index.php');

use common\models\FileStorageItem;

$errors = FileStorageItem::downloadFile($_GET['id']);

if (!empty($_GET['id']) && empty($errors)) {
    header('Location: /frontend/views/cabinet/actionCabinet.php');
}

foreach ($errors as $error) {
    echo $error . '<br>';
}