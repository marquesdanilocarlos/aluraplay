<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\File;
use Aluraplay\FlashMessage;
use Aluraplay\Repository\VideoRepository;
use Exception;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use const FILTER_VALIDATE_INT;
use const INPUT_GET;

class DeleteController extends Controller implements RequestHandlerInterface
{
    public function __construct(private readonly VideoRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $queryParams = $request->getQueryParams();
            $id = filter_var($queryParams["id"], FILTER_VALIDATE_INT);
            $video = $this->repository->video($id);

            if (!$id || empty($video)) {
                FlashMessage::addMessage("Video não encontrado.", MESSAGE_ERROR);
                return new Response(301, [
                    "Location" => "/"
                ]);
            }

            $videoImagePath = $video->getImagePath();

            if ($videoImagePath) {
                File::remove($videoImagePath);
            }

            $result = $this->repository->remove($id);

            if ($result) {
                FlashMessage::addMessage("Video deletado com sucesso!", MESSAGE_SUCCESS);
                return new Response(301, [
                    "Location" => "/"
                ]);
            }
        } catch (Exception $e) {
            FlashMessage::addMessage($e->getMessage(), MESSAGE_ERROR);
            return new Response(500, [
                "Location" => "/"
            ]);
        }
    }
}