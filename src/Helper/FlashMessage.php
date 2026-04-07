<?php

namespace Alura\Mvc\Helper;

trait FlashMessage
{
    private function addErroMessage(string $erroMessage): void
    {
        $_SESSION['error_message'] = $erroMessage;
    }
}