<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\Entity\Video;
use Aluraplay\Repository\VideoRepository;

class NewJsonController extends Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function dispatch(): void
    {
        $request = file_get_contents("php://input");
        $videoData = json_decode($request, true);

        $video = new Video($videoData["url"], $videoData["title"]);
        $this->videoRepository->insert($video);

        http_response_code(201);
    }
}