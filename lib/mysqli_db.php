<?php

class MySQLi_DB {
    private static $host   = 'localhost';
    private static $user   = 'root';
    private static $pass   = '';
    private static $db     = 'php_pro';

    private static $aaa;

    private static function connection() {

        $conn = new mysqli(self::$host, self::$user, self::$pass, self::$db);
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Check connection
        if ($conn->connect_error) {
            die("<br>Faild DB Connection: " . $conn->connect_error);
        }

        self::$aaa = $conn;

        return $conn;
    }

    public static function prepare($sql) {
        return self::connection()->prepare($sql);
    }

    public static function query($sql) {
        return self::connection()->query($sql);
    }
}