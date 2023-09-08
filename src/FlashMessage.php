<?php

namespace Aluraplay;

trait FlashMessage
{
    public static function addMessage(string $message, string $type = MESSAGE_DEFAULT): void
    {
        $_SESSION["message"] = [
            "message" => $message,
            "type" => $type
        ];
    }

    public static function showMessage(): array
    {
        if (isset($_SESSION["message"])) {
            $message = $_SESSION["message"];
            unset($_SESSION["message"]);
            return $message;
        }

        return [];
    }
}