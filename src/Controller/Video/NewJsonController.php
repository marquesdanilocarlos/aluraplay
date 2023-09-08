<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\Entity\Video;
use Aluraplay\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NewJsonController extends Controller implements RequestHandlerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $request = file_get_contents("php://input");
        $videoData = json_decode($request, true);

        $video = new Video($videoData["url"], $videoData["title"]);
        $this->videoRepository->insert($video);

        http_response_code(201);
    }
}