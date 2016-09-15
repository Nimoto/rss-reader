<?php

class DataBase {
    private static $db;
    private static $dbSettings = array();

    private function __construct($dbSettings) {
        self::$dbSettings = $dbSettings;
    }

    public static function init($dbSettings = null) {
        if (!self::$db) {
            self::$db = new DataBase($dbSettings);
        }
        return self::$db;
    }

    public static function getHost() {
        return self::$dbSettings["host"];
    }

    public static function getUser() {
        return self::$dbSettings["user"];
    }

    public static function getPass() {
        return self::$dbSettings["pass"];
    }

    public static function getDbName() {
        return self::$dbSettings["db_name"];
    }
}

?>