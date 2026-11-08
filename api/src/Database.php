<?php
declare(strict_types=1);
namespace Northwind;

final class Database
{
    private static ?\PDO $connection = null;

    public static function connection(array $settings): \PDO
    {
        if (self::$connection === null) {
            self::$connection = new \PDO(
                "mysql:host={$settings['host']};port={$settings['port']};dbname={$settings['name']};charset={$settings['charset']}",
                $settings['user'],
                $settings['pass'],
                [\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
                 \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_ASSOC,
                 \PDO::ATTR_EMULATE_PREPARES=>false]
            );
        }
        return self::$connection;
    }
}
