<?php

namespace Aluraplay\Controller;

use Aluraplay\FlashMessage;

abstract class Controller
{

    protected function render(string $templateName, array $context = []): string
    {
        $context["message"] = FlashMessage::showMessage();
        extract($context);

        ob_start();
        require_once TEMPLATE_PATH . $templateName . ".php";
        return ob_get_clean();
    }
}