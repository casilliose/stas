<?php

namespace common\models;

use common\components\Db;
use stdClass;

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
        $result = $db->query('SELECT id, name, type FROM ' . self::$tableName . ' ORDER BY id DESC');

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