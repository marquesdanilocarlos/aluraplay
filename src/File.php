<?php

namespace Aluraplay;

use Exception;

class File
{
    public static function upload(?array $fileData = null, string $existentFile = ""): ?string
    {
        $fileName = null;

        if (!empty($fileData["tmp_name"])) {
            if ($fileData["type"] && !in_array($fileData["type"], UPLOAD_ALLOWED_EXTENSIONS)) {
                throw new Exception("O formato do arquivo enviado não é válido.");
            }

            if ($fileData["error"] !== UPLOAD_ERR_OK) {
                throw new Exception("Algum erro ocorreu ao realizar o upload.");
            }

            self::remove($existentFile);

            $extension = ltrim(strstr($fileData["type"], "/"), "/");
            $fileName = IMAGE_FILE_PATH . uniqid("video_cover_") . ".{$extension}";

            move_uploaded_file($fileData["tmp_name"], FILES_PATH . $fileName);
        }

        return $fileName;
    }

    public static function remove($existentFile)
    {
        if (file_exists($existentFile)) {
            unlink($existentFile);
        }
    }
}