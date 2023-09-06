<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\Entity\Video;
use Aluraplay\File;
use Aluraplay\Repository\VideoRepository;
use Exception;
use PDO;
use stdClass;

class EditController extends Controller
{
    public function __construct(private readonly VideoRepository $repository)
    {
    }

    public function dispatch(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT)
            ?? filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);;

        try {
            $video = $this->repository->video($id);

            if ($_SERVER['REQUEST_METHOD'] === "GET") {
                $this->render("video/form", [
                    "video" => $video
                ]);
                return;
            }

            $data = filter_input_array(INPUT_POST, [
                "url" => FILTER_VALIDATE_URL,
                "title" => FILTER_SANITIZE_SPECIAL_CHARS
            ]);

            $videoImage = File::upload($_FILES["image"] ?? null, $video->getImagePath());

            $video = new Video(...$data);
            $video->setId($id);
            $video->setImagePath($videoImage);

            $result = $this->repository->update($video);

            if ($result) {
                header("Location: /");
            }
        } catch (Exception $e) {
            echo "<h1>{$e->getMessage()}</h1>";
        }
    }
}