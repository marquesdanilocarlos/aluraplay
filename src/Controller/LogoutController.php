<?php

namespace Aluraplay\Controller;

class LogoutController extends Controller
{
    public function dispatch(): void
    {
        session_destroy();
        header("Location: /login");
    }

}