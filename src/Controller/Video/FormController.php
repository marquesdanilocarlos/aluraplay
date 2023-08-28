<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\Repository\VideoRepository;
use Exception;
use stdClass;

use const FILTER_VALIDATE_INT;
use const INPUT_GET;

class FormController extends Controller
{
    public function __construct(private readonly VideoRepository $repository)
    {
    }

    public function dispatch(): void
    {
        try {
            $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

            if (!empty($id)) {
                $video = $this->repository->video($id);
            } else {
                $video = new stdClass();
                $video->title = "";
                $video->url = "";
            }

            require_once __DIR__ . "/../../../form.php";
        } catch (Exception $e) {
            echo "<h1>{$e->getMessage()}</h1>";
        }
    }
}