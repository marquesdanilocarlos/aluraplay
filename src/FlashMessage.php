<?php

namespace Aluraplay;

trait FlashMessage
{
    public static function addMessage(string $message): void
    {
        $_SESSION["message"] = $message;
    }

    public static function showMessage(): string
    {
        if (isset($_SESSION["message"])) {
            $message = $_SESSION["message"];
            unset($_SESSION["message"]);
            return $message;
        }

        return "";
    }
}