<?php

require_once('../../../index.php');

use common\models\FileStorageItem;
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP-UP</title>
    <meta charset="utf-8"/>
</head>
<body>
<h2>Формы:</h2>
<div>
    <span><?php echo FileStorageItem::uploadFile(); ?></span>
</div>
<br>
<div>
    <span><b>Загрузить еще один файл?</b></span>
</div>
<form action="form.php">
    <button>Загрузить</button>
</form>
</body>
</html>