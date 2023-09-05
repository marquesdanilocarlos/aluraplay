<?php

namespace Aluraplay\Entity;

use InvalidArgumentException;

class Video
{
    private string $url = "";
    public readonly int $id;

    private ?string $imagePath = null;

    public function __construct(string $url, public readonly string $title)
    {
        $this->setUrl($url);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        if (!filter_var($url, FILTER_VALIDATE_URL) && $url !== "") {
            throw new InvalidArgumentException();
        }
        $this->url = $url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }


}