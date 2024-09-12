<?php

namespace data\superGlobal;

use Exception;

class Get extends AbstractSuperGlobal
{
    public static string $path;

    public function __construct(?string $getData = null) {
        foreach ($getData ?? $_GET as $key => $value) {
            $this->sanitize($key, $value);

            if(!property_exists(self::class, $key)) {
               throw new Exception("GET property '$key' does not exist");
            }

            self::$$key = $value;
        }
    }

}