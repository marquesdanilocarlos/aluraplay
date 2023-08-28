<?php

namespace Aluraplay\Entity;

use InvalidArgumentException;

class Video
{
    public readonly string $url;
    public readonly int $id;

    public function __construct(string $url, public readonly string $title)
    {
        $this->setUrl($url);
    }

    private function setUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException();
        }
        $this->url = $url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}