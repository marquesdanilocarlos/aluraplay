<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\Entity\Video;
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
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        try {
            if ($_SERVER['REQUEST_METHOD'] === "GET") {
                $video = $this->repository->video($id);
                require_once __DIR__ . "/../../../views/video/form.php";
                return;
            }

            $data = filter_input_array(INPUT_POST, [
                "url" => FILTER_VALIDATE_URL,
                "title" => FILTER_SANITIZE_SPECIAL_CHARS
            ]);

            if (in_array(false, $data)) {
                header("Location: /");
                exit;
            }

            $video = new Video(...$data);
            $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
            $video->setId($id);
            $result = $this->repository->update($video);

            if ($result) {
                header("Location: /");
            }
        } catch (Exception $e) {
            echo "<h1>{$e->getMessage()}</h1>";
        }
    }
}