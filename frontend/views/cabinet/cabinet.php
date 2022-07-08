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
        <?php foreach ($files as $file) {
            echo "<li>" . $file['file_name'] . " <a href=''>Удалить</a>   <a href=''>Скачать</a></li>";
        } ?>
    </ul>
</div>

</body>
</html>