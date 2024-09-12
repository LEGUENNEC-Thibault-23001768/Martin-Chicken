<?php

namespace domain;

class User extends AbstractEntity
{
    use IdTrait;
    private Credentials $credentials;
    public function __construct(string $name, string $password) {
        $this->credentials = new Credentials($name, $password);
    }
    public function getCredentials(): Credentials {
        return $this->credentials;
    }
}