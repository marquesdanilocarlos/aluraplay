<?php

namespace Aluraplay\Controller;

use Aluraplay\FlashMessage;

abstract class Controller
{
    use FlashMessage;

    protected abstract function dispatch(): void;

    protected function render(string $templateName, array $context = []): void
    {
        $context["message"] = self::showMessage();
        extract($context);

        require_once TEMPLATE_PATH . $templateName . ".php";
    }
}