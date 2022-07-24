<?php

namespace common\models;

use common\components\Db;

class User
{
    /**
     * @param string $email
     * @param string $password
     * @return bool|int
     */
    public static function checkUserData(string $email, string $password): bool|int
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, \PDO::PARAM_INT);
        $result->bindParam(':password', $password, \PDO::PARAM_INT);
        $result->execute();

        $user = $result->fetch(\PDO::FETCH_ASSOC);
        if ($user) {
            return $user['id'];
        }

        return false;
    }

    /**
     * @param int $userId
     * @return void
     */
    public static function auth(int $userId): void
    {
        session_start();
        $_SESSION['user'] = $userId;
    }

}