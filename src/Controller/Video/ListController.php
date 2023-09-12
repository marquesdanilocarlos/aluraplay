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
use League\Plates\Engine;

class ListController extends Controller implements RequestHandlerInterface
{

    public function __construct(
        private readonly VideoRepository $repository,
        private readonly Engine $template
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $videos = $this->repository->all();
            return new Response(200, [], $this->template->render('video/list-videos', [
                "videos" => $videos
            ]));
        } catch (Exception $e) {
            FlashMessage::addMessage($e->getMessage(), MESSAGE_ERROR);
            return new Response(500);
        }
    }
}