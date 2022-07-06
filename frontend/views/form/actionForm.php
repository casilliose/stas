<?php
$uploadsDir = 'uploads/';

if (!empty($_FILES) && $_FILES["filename"]["error"] == UPLOAD_ERR_OK) {
    $fileName = $_FILES["filename"]["name"];
    $parts = explode('.', $fileName);
    $extension = array_pop($parts);
    $fileName = implode($parts);
    $fileName = $fileName . '(' . date('Y-m-d H:i:s') . ').' . $extension;
    move_uploaded_file($_FILES["filename"]["tmp_name"], $uploadsDir . $fileName);
    echo 'Файл "' . $fileName . '" загружен';
} else {
    echo 'Ошибка при загрузке файла!';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP-UP</title>
    <meta charset="utf-8"/>
</head>
<body>
<h2>Загрузить еще один файл?</h2>
<form action="form.php">
    <button>Да</button>
</form>
</body>
</html>