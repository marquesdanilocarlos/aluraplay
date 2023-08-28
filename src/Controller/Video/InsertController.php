<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\Entity\Video;
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
            $video = new stdClass();
            $video->title = "";
            $video->url = "";
            require_once __DIR__ . "/../../../views/video/form.php";
            return;
        }

        try {

            $data = filter_input_array(INPUT_POST, [
                "url" => FILTER_VALIDATE_URL,
                "title" => FILTER_SANITIZE_SPECIAL_CHARS
            ]);

            if (in_array(false, $data)) {
                header("Location: /");
                exit;
            }

            $result = $this->repository->insert(new Video(...$data));

            if ($result) {
                header("Location: /");
            }


        } catch (Exception $e) {
            echo "<h1>{$e->getMessage()}</h1>";
        }
    }
}