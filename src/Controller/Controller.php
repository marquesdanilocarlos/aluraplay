<?php

namespace Aluraplay\Controller;

use Aluraplay\FlashMessage;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Controller
{
    use FlashMessage;

    protected function render(string $templateName, array $context = []): string
    {
        $context["message"] = self::showMessage();
        extract($context);

        ob_start();
        require_once TEMPLATE_PATH . $templateName . ".php";
        return ob_get_clean();
    }
}