<?php
/** @var $files array */
?>

<!DOCTYPE html>
<html>
<head>
    <title>Personal Cabinet</title>
    <meta charset="utf-8"/>
</head>
<body>
<h2>Кабинет пользователя</h2>

<div>
    <ul>
        <?php foreach ($files as $id => $file) {
            echo "<li>" . $file['file_name'] . " <a href='/frontend/views/cabinet/actionDelete.php?id=" . $id . "'>Удалить</a>   <a href='/frontend/views/cabinet/actionDownloadFile.php?id=" . $id . "'>Скачать</a></li>";
        } ?>
    </ul>
</div>

</body>
</html>