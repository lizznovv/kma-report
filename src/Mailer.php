<?php

class Mailer
{
    private string $host;
    private int $port;

    public function __construct(string $host, int $port){
        $this->host = $host;
        $this->port = $port;
    }

    public function send(string $email, string $message): void
    {
        echo "Sending report to {$email}";
    }
}