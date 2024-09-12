<?php

namespace data\superGlobal;

use Exception;

class Post extends AbstractSuperGlobal
{
    public static string $action;
    public static string $name;
    public static string $password;
    public static string $redirection;
    public function __construct(?string $postData = null) {
        foreach ($postData ?? $_POST as $key => $value) {
            $this->sanitize($key, $value);

            if(!property_exists(self::class, $key)) {
                throw new Exception("POST property '$key' does not exist");
            }

            self::$$key = $value;
        }
    }
}