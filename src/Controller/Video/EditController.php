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


class EditController extends Controller implements RequestHandlerInterface
{
    use FlashMessage;

    public function __construct(private readonly VideoRepository $repository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT)
            ?? filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);;

        try {
            $video = $this->repository->video($id);

            if ($_SERVER['REQUEST_METHOD'] === "GET") {
                return new Response(200, [], $this->render("video/form", [
                    "id" => $id,
                    "video" => $video
                ]));
            }

            $data = filter_input_array(INPUT_POST, [
                "url" => FILTER_VALIDATE_URL,
                "title" => FILTER_SANITIZE_SPECIAL_CHARS
            ]);

            $videoImage = File::upload($_FILES["image"] ?? null, $video->getImagePath() ?? "");

            $video = new Video(...$data);
            $video->setId($id);
            $video->setImagePath($videoImage);

            $result = $this->repository->update($video);

            if ($result) {
                self::addMessage("Video editado com sucesso!", MESSAGE_SUCCESS);
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