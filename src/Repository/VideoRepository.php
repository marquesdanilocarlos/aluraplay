<?php

namespace Aluraplay\Repository;

use Aluraplay\Database\Connection;
use Aluraplay\Entity\Video;
use Exception;
use PDO;

use function array_map;
use function intval;

class VideoRepository
{
    public function __construct(private PDO $connection)
    {
    }

    public function insert(Video $video): bool
    {
        $query = "INSERT INTO videos (title, url) VALUES (:title, :url)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(":title", $video->title);
        $stmt->bindValue(":url", $video->url);

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
        $connection = Connection::getInstance();
        $query = "UPDATE videos SET url = :url, title = :title WHERE id = :id";
        $stmt = $connection->prepare($query);
        $stmt->bindValue(":url", $video->url);
        $stmt->bindValue(":title", $video->title);
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
            return $video;
        }, $videos);
    }
}