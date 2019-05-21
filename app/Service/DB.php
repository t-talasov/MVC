<?php

namespace App\Service;

class DB
{
    private static $instance = null;

    public static function get()
    {
        if (self::$instance === null) {
            $host = '127.0.0.1';
            $db   = 'project';
            $user = 'admin';
            $pass = 'w21w21';
            $charset = 'utf8';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $opt = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            self::$instance = new \PDO($dsn, $user, $pass, $opt);
        }

        return self::$instance;
    }
    
}