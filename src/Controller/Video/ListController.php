<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\FlashMessage;
use Aluraplay\Repository\VideoRepository;
use Exception;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListController extends Controller implements RequestHandlerInterface
{
    use FlashMessage;

    public function __construct(private VideoRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $videos = $this->repository->all();
            return new Response(200, [], $this->render("video/list-videos", [
                "videos" => $videos
            ]));
        } catch (Exception $e) {
            self::addMessage($e->getMessage(), MESSAGE_ERROR);
            return new Response(500);
        }
    }
}