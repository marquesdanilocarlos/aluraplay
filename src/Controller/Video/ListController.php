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
            $this->render("video/list-videos", [
                "videos" => $videos
            ]);
        } catch (Exception $e) {

        }
    }
}