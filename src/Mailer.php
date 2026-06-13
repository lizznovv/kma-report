<?php

class Mailer
{
    public function send(string $email, string $message): void
    {
        echo "Sending report to {$email}";
    }
}