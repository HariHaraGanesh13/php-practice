<?php

class User
{
    private string $name;
    private string $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function getProfile(): string
    {
        return "Name: {$this->name}, Email: {$this->email}";
    }
}
