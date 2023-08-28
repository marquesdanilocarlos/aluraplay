<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\Repository\VideoRepository;
use Exception;

class ListController extends Controller
{
    public function __construct(private VideoRepository $repository)
    {
    }

    public function dispatch(): void
    {
        try {
            $videos = $this->repository->all();
            require_once __DIR__ . "/../../../views/video/list-videos.php";
        } catch (Exception $e) {
            echo "<h1>{$e->getMessage()}</h1>";
        }
    }
}