<?php
declare(strict_types=1);
namespace Northwind;

final class Database
{
    private static ?\PDO $connection = null;

    public static function connection(array $settings): \PDO
    {
        if (self::$connection === null) {
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];
            if (defined('\PDO::MYSQL_ATTR_MULTI_STATEMENTS')) {
                $options[\PDO::MYSQL_ATTR_MULTI_STATEMENTS] = true;
            }

            self::$connection = new \PDO(
                "mysql:host={$settings['host']};port={$settings['port']};dbname={$settings['name']};charset={$settings['charset']}",
                $settings['user'],
                $settings['pass'],
                $options
            );

            self::ensureSchema(self::$connection);
        }
        return self::$connection;
    }

    private static function ensureSchema(\PDO $pdo): void
    {
        try {
            $stmt = $pdo->query("SHOW TABLES LIKE 'tb_users'");
            if ($stmt && $stmt->fetchColumn() === false) {
                $sqlFile = dirname(__DIR__, 2) . '/dbNorthwind.sql';
                if (is_file($sqlFile)) {
                    $sql = file_get_contents($sqlFile);
                    if ($sql) {
                        $pdo->exec($sql);
                    }
                }
            }
        } catch (\Throwable $e) {
            error_log('Database schema initialization: ' . $e->getMessage());
        }
    }
}
