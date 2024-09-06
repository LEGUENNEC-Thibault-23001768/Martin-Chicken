<?php


define("DB_ADDR", "mysql-martin-chicken.alwaysdata.net");
define("DB_USER","374927");
define("DB_PASS","lechatrouge");
define("DB_NAME","martin-chicken_db");

class Database {
    private static $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new mysqli(DB_ADDR, DB_USER, DB_PASS, DB_NAME);
        }
        return self::$instance;
    }
    
}
?>