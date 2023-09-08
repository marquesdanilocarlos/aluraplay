<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\Entity\Video;
use Aluraplay\Repository\VideoRepository;

class JsonListController extends Controller implements RequestHandlerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(): void
    {
        $videoList = array_map(function (Video $video): array {
            return [
                "url" => $video->getUrl(),
                "title" => $video->title,
                "file_path" => FILES_PATH . $video->getImagePath()
            ];
        }, $this->videoRepository->all());
        echo json_encode($videoList);
    }
}