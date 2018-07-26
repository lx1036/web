<?php


namespace Tests;


final class Database
{
    private static $db_name;

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public static function createSchema(string $prefix, string $username, string $password, string $host = '127.0.0.1', string $port = '3306', string $charset = 'utf8mb4', string $collation = 'utf8mb4_unicode_ci')
    {
        $db_name = $prefix . '_' . date('ymd') . '_' . str_random(4);
        static::$db_name = $db_name;
        $dsn = "mysql:dbname=$db_name;host=$host;port=$port;charset=$charset;collation=$collation";

        $pdo = new \PDO($dsn, $username, $password);

        $statement = $pdo->prepare(file_get_contents(__DIR__ . '/mysql.sql'));

        if (false === $statement) {
            dump('Can\'t prepare ' . __DIR__ . '/mysql.sql, maybe the mysql.sql is large or the database connection is wrong.');

            die;
        }

        if (false === $statement->execute()) {
            dump('Can\'t create schema from ' . __DIR__ . '/mysql.sql.');

            die;
        }

    }
}