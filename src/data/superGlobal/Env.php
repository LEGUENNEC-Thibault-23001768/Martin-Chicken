<?php

namespace data\superGlobal;

class Env extends AbstractSuperGlobal
{
    public static string $DSN;
    public static string $username;
    public static string $password;


    /**
     * TODO inverser pour s'assurer que tous les attributs sont remplis et non l'inverse
     *
     * @param string|null $envData
     */
    public function __construct(?string $envData = null) {
        foreach ($getData ?? $_ENV as $key => $value) {
            $this->sanitize($key, $value);

            if(property_exists(self::class, $key)) {
                self::$$key = $value;
            }
        }
    }
}