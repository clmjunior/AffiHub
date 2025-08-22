<?php


namespace app\database;

// use app\helpers\ConfigHelper;

use mysqli;

class DBConn
{
    private static $conn = null;
   
    public static function getConnection()
    {
        if (self::$conn) return self::$conn;

        // ConfigHelper::loadEnv();

        $host = getenv('DB_HOST');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');
        $db   = getenv('DB_DATABASE');

        self::$conn = new mysqli($host, $user, $pass, $db);
        if (self::$conn->connect_error) {
            die("Erro na conexão: " . self::$conn->connect_error);
        }

        return self::$conn;
    }
}
