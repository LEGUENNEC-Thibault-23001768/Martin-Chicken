<?php

namespace data\superGlobal;

use Exception;

class Session extends AbstractSuperGlobal
{
    public static string $name;
    public static string $password;
    public function __construct(?string $sessionData = null) {
        foreach ($sessionData ?? $_SESSION ?? [] as $key => $value) {
            $this->sanitize($key, $value);

            if(!property_exists(self::class, $key)) {
                throw new Exception("SESSION property '$key' does not exist");
            }

            self::$$key = $value;
        }
    }
    public static function start() {
        session_start();
    }
    public static function destroy() {
        session_destroy();
    }

    public static function getName(): string
    {
        return self::$name;
    }

    public static function setName(string $name): void
    {
        self::$name = $name;
    }

    public static function getPassword(): string
    {
        return self::$password;
    }

    public static function setPassword(string $password): void
    {
        self::$password = $password;
    }

}