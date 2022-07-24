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
    <p>Список загруженных файлов:</p>
    <ul>
        <?php foreach ($files as $id => $file) {
            echo "<li>" . $file['file_name'] . " <a href='/frontend/views/cabinet/actionDelete.php?id=" . $id . "'>Удалить</a>   <a href='/frontend/views/cabinet/actionDownloadFile.php?id=" . $id . "'>Скачать</a></li>";
        } ?>
    </ul>
</div>
<hr>
<p>Загрузить новый файл:</p>
<form action="actionUploadFile.php" method="post" enctype="multipart/form-data">
    Выберите файл:
    <input type="file" name="filename" size="10"/><br/><br/>
    <input type="submit" value="Загрузить"/>
</form>

</body>
</html>