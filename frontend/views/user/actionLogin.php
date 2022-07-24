<?php

require_once('../../../index.php');

use common\models\User;

$email = '';
$password = '';

if (!empty($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $errors = '';

    $userId = User::checkUserData($email, $password);

    if ($userId === false) {
        $errors = 'Неверные данные для входа на сайт';
        echo $errors;
    } else {
        User::auth($userId);
        header('Location: /frontend/views/cabinet/actionCabinet.php');
    }

    return true;

}

