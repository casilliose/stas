<?php

require_once('../../../index.php');

use common\models\FileStorageItem;

$errors = FileStorageItem::uploadFile();

if (empty($errors)) {
    header('Location: /frontend/views/cabinet/actionCabinet.php');
}

foreach ($errors as $error) {
    echo $error . '<br>';
}