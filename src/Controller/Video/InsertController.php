<?php

namespace Aluraplay\Controller\Video;

use Aluraplay\Controller\Controller;
use Aluraplay\Entity\Video;
use Aluraplay\File;
use Aluraplay\FlashMessage;
use Aluraplay\Repository\VideoRepository;
use Exception;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class InsertController extends Controller implements RequestHandlerInterface
{
    use FlashMessage;

    public function __construct(private readonly VideoRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $video = new Video("", "");
            return new Response(200, [], $this->render("video/form", [
                "video" => $video
            ]));
        }

        try {
            $data = filter_input_array(INPUT_POST, [
                "url" => FILTER_VALIDATE_URL,
                "title" => FILTER_SANITIZE_SPECIAL_CHARS
            ]);

            $video = new Video(...$data);
            $videoImage = File::upload($_FILES["image"] ?? null);
            $video->setImagePath($videoImage);
            $result = $this->repository->insert($video);

            if ($result) {
                self::addMessage("Video inserido com sucesso!", MESSAGE_SUCCESS);
                return new Response(301, [
                    "Location" => "/"
                ]);
            }
        } catch (Exception $e) {
            self::addMessage($e->getMessage(), MESSAGE_ERROR);
            return new Response(500, [
                "Location" => "/"
            ]);
        }
    }
}