<?php

namespace common\models;

use common\components\Db;

class FileStorageItem
{
    const UPLOADS_DIR = '../../../uploads/';

    public static string $tableName = 'file_storage_item';

    /**
     * @return string
     */
    public static function uploadFile(): string
    {
        if (!empty($_FILES) && $_FILES["filename"]["error"] == UPLOAD_ERR_OK) {
            $baseUrl = self::UPLOADS_DIR;
            $fileName = $_FILES["filename"]["name"];
            $parts = explode('.', $fileName);
            $extension = array_pop($parts);
            $fileName = implode($parts);
            $fileName = $fileName . '(' . date('Y-m-d H:i:s') . ')';
            $path = self::UPLOADS_DIR . $fileName . '.' . $extension;
            $createdAt = time();
            move_uploaded_file($_FILES["filename"]["tmp_name"], $path);

            $db = Db::getConnection();
            $sql = 'INSERT INTO  ' . self::$tableName . ' (base_url, path, type, name, created_at) VALUES (:base_url, :path, :type, :name, :created_at)';
            $result = $db->prepare($sql);
            $result->bindParam(':base_url', $baseUrl, \PDO::PARAM_STR);
            $result->bindParam(':path', $path, \PDO::PARAM_STR);
            $result->bindParam(':type', $extension, \PDO::PARAM_STR);
            $result->bindParam(':name', $fileName, \PDO::PARAM_STR);
            $result->bindParam(':created_at', $createdAt, \PDO::PARAM_INT);

            if ($result->execute()) {
                return 'Файл "' . $fileName . '.' . $extension . '" загружен';
            } else {
                return 'Ошибка при вставке записи в БД!';
            }
        } else {
            return 'Ошибка при загрузке файла!';
        }
    }

    /**
     * @return array
     */
    public static function getFileNames(): array
    {
        $db = Db::getConnection();

        $files = [];
        $result = $db->query('SELECT name, type FROM ' . self::$tableName . ' ORDER BY id DESC');

        $i = 0;
        while ($row = $result->fetch()) {
            $files[$i]['file_name'] = $row['name'] . '.' . $row['type'];
            $i++;
        }

        return $files;

    }

    public static function deleteFile()
    {

    }

}