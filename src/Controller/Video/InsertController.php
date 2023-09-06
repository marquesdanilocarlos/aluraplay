<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\Entity\Video;
use Aluraplay\File;
use Aluraplay\Repository\VideoRepository;
use Exception;
use stdClass;

class InsertController extends Controller
{
    public function __construct(private readonly VideoRepository $repository)
    {
    }

    public function dispatch(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $video = new Video("", "");
            $this->render("video/form", [
                "video" => $video
            ]);
            return;
        }

        try {

            $data = filter_input_array(INPUT_POST, [
                "url" => FILTER_VALIDATE_URL,
                "title" => FILTER_SANITIZE_SPECIAL_CHARS
            ]);

            $video = new Video(...$data);
            $videoImage = File::upload($_FILES["image"] ?? null);
            $video->setImagePath($videoImage);
            $result = $this->repository->insert($video);

            if ($result) {
                header("Location: /");
            }

        } catch (Exception $e) {
            echo "<h1>{$e->getMessage()}</h1>";
        }
    }
}