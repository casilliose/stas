<!DOCTYPE html>
<html>
<head>
    <title>Forms</title>
    <meta charset="utf-8"/>
</head>
<body>
<h2>Загрузка файла</h2>
<form action="actionForm.php" method="post" enctype="multipart/form-data">
    Выберите файл: <input type="file" name="filename" size="10"/><br/><br/>
    <input type="submit" value="Загрузить"/>
</form>
</body>
</html>