<?php

namespace domain;

class Credentials
{
    private string $name;
    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->name = $username;
        if ($this->isPasswordHashed($password)) {
            $this->password = $password;
        } else {
            $this->password = $this->passwordHash($password);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    private function passwordHash($password): string
    {
        return password_hash($password, PASSWORD_HASH_ALGORITHM);
    }

    private function isPasswordHashed(string $password): bool
    {
        return password_needs_rehash($password, PASSWORD_HASH_ALGORITHM);
    }
}