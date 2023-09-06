<?php

namespace Aluraplay\Controller;

abstract class Controller
{
    protected abstract function dispatch(): void;

    protected function render(string $templateName, array $context = []): void
    {
        extract($context);
        require_once TEMPLATE_PATH . $templateName . ".php";
    }
}