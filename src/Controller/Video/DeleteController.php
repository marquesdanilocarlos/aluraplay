<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\File;
use Aluraplay\Repository\VideoRepository;
use Exception;

use const FILTER_VALIDATE_INT;
use const INPUT_GET;

class DeleteController extends Controller
{
    public function __construct(private readonly VideoRepository $repository)
    {
    }

    public function dispatch(): void
    {
        try {
            $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
            $video = $this->repository->video($id);
            $videoImagePath = $video->getImagePath();

            if ($videoImagePath) {
                File::remove($videoImagePath);
            }

            $result = $this->repository->remove($id);

            if ($result) {
                header("Location: /");
            }
        } catch (Exception $e) {
            echo "<h1>{$e->getMessage()}</h1>";
        }
    }
}