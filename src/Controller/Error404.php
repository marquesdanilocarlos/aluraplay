<?php

namespace Aluraplay\Controller;

class Error404
{
    public function dispatch()
    {
        http_response_code(404);
    }
}