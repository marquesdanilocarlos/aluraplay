<?php

namespace Aluraplay\Controller;

abstract class Controller
{
    protected abstract function dispatch(): void;
}