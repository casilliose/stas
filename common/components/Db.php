<?php

namespace common\components;

class Db
{
    /**
     * @return \PDO
     */
    public static function getConnection(): \PDO
    {
        try {
            $dsn = 'mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_DATABASE');
            $db = new \PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
            $db->exec('set names utf8');
        } catch (\PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

        return $db;
    }

}