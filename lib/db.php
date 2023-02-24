<?php

class DB {
    private static $host   = 'localhost';
    private static $db     = 'php_pro';
    private static $user   = 'root';
    private static $pass   = '';

    private static function connection() {
        try {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db;
            $conn = new PDO($dsn, self::$user, self::$pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $conn;
        } catch (PDOException $e) {
            die('Faild DB Connection: ') . $e->getMessage();
        }
    }

    public static function prepare($sql) {
        return self::connection()->prepare($sql);
    }
}