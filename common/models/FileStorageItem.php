<?php

namespace common\models;

use common\components\Db;
use stdClass;

class FileStorageItem
{
    const UPLOADS_DIR = '../../../uploads/';

    public static string $tableName = 'file_storage_item';

    /**
     * @return array
     */
    public static function uploadFile(): array
    {
        $errors = [];
        $userId = User::checkLogged();

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
            $sql = 'INSERT INTO  ' . self::$tableName . ' (user_id, base_url, path, type, name, created_at) VALUES (:user_id, :base_url, :path, :type, :name, :created_at)';
            $result = $db->prepare($sql);
            $result->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $result->bindParam(':base_url', $baseUrl, \PDO::PARAM_STR);
            $result->bindParam(':path', $path, \PDO::PARAM_STR);
            $result->bindParam(':type', $extension, \PDO::PARAM_STR);
            $result->bindParam(':name', $fileName, \PDO::PARAM_STR);
            $result->bindParam(':created_at', $createdAt, \PDO::PARAM_INT);

            if (!$result->execute()) {
                $errors[] = 'Ошибка при вставке записи в БД!';
            }

            return $errors;
        }

        $errors[] = 'Файл не выбран!';
        return $errors;
    }

    /**
     * @return array
     */
    public static function getAllFileNames(): array
    {
        $db = Db::getConnection();

        $files = [];
        $result = $db->query('SELECT id, name, type FROM ' . self::$tableName . ' ORDER BY id DESC');

        while ($row = $result->fetch()) {
            $files[$row['id']]['file_name'] = $row['name'] . '.' . $row['type'];
        }

        return $files;
    }

    /**
     * @param int|null $userId
     * @return array
     */
    public static function getFileNamesByUserId(int $userId = null): array
    {
        $db = Db::getConnection();

        $files = [];
        $result = $db->query('SELECT id, name, type FROM ' . self::$tableName . ' WHERE user_id=' . $userId . ' ORDER BY id DESC');

        while ($row = $result->fetch()) {
            $files[$row['id']]['file_name'] = $row['name'] . '.' . $row['type'];
        }

        return $files;
    }

    /**
     * @param $id
     * @return array
     */
    public static function deleteFile($id): array
    {
        $errors = [];
        $db = Db::getConnection();
        $model = self::getModelById($id);

        if (!empty($model)) {
            $filePath = $model->path ?? '';
            $result = $db->query('DELETE FROM ' . self::$tableName . ' WHERE id=' . $id);

            if ($result->execute()) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            } else {
                $errors[] = 'Ошибка удаления файла!';
            }

            return $errors;
        }

        $errors[] = 'Файл не найден в БД!';

        return $errors;
    }

    /**
     * @param $id
     * @return bool|stdClass
     */
    public static function getModelById($id): bool|stdClass
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT * FROM ' . self::$tableName . ' WHERE id=' . $id);

        return $result->fetchObject();
    }

    /**
     * @param $id
     * @return array
     */
    public static function downloadFile($id): array
    {
        $errors = [];
        $model = self::getModelById($id);

        if (!empty($model)) {
            $filePath = $model->path ?? '';
            header("Content-Type: image/png");
            header("Content-Length: " . filesize($filePath));
            $quoted = sprintf('"%s"', addcslashes(basename($filePath), '"\\'));
            header("Content-Disposition: attachment; filename=$quoted");
            $fp = fopen($filePath, 'rb');
            fpassthru($fp);

            return $errors;
        }

        $errors[] = 'Файл не найден в БД!';
        return $errors;
    }

}