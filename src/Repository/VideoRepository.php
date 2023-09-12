<?php

namespace Aluraplay\Repository;

use Aluraplay\Entity\Video;
use Exception;
use PDO;

class VideoRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function video(int $id): ?Video
    {
        $query = "SELECT * FROM videos WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Não foi possível deletar o vídeo da base de dados.");
        }

        $videoData = $stmt->fetch();

        if (!$videoData) {
            return null;
        }

        $video = new Video($videoData["url"], $videoData["title"]);
        $video->setImagePath($videoData["image_path"]);
        $video->setId($videoData["id"]);

        return $video;
    }

    public function insert(Video $video): bool
    {
        $query = "INSERT INTO videos (title, url, image_path) VALUES (:title, :url, :imagePath)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(":title", $video->title);
        $stmt->bindValue(":url", $video->getUrl());
        $stmt->bindValue(":imagePath", $video->getImagePath());

        if (!$stmt->execute()) {
            throw new Exception("Não foi possível inserir o vídeo na base de dados.");
        }

        $id = $this->connection->lastInsertId();
        $video->setId(intval($id));

        return true;
    }

    public function remove(int $id): bool
    {
        $query = "DELETE FROM videos WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Não foi possível deletar o vídeo da base de dados.");
        }

        return true;
    }

    public function update(Video $video): bool
    {
        $imagePathSql = $video->getImagePath() ? ", image_path = :imagePath" : "";
        $query = "UPDATE videos SET url = :url, title = :title {$imagePathSql} WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(":url", $video->getUrl());
        $stmt->bindValue(":title", $video->title);
        if ($imagePathSql) {
            $stmt->bindValue(":imagePath", $video->getImagePath());
        }
        $stmt->bindValue(":id", $video->id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Não foi possível editar o vídeo na base de dados.");
        }

        return true;
    }

    /**
     * @return Video[]
     */
    public function all(): array
    {
        $query = "SELECT * FROM videos";
        $stmt = $this->connection->prepare($query);
        if (!$stmt->execute()) {
            throw new Exception("Não foi possível recuperar os vídeos da base de dados.");
        }

        $videos = $stmt->fetchAll();

        return array_map(function (array $videoData) {
            $video = new Video($videoData["url"], $videoData["title"]);
            $video->setId($videoData["id"]);
            $video->setImagePath($videoData["image_path"]);
            return $video;
        }, $videos);
    }
}