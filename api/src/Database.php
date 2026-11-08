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
            $hasUsersTable = $stmt && $stmt->fetchColumn() !== false;
            if (!$hasUsersTable) {
                $sqlFile = dirname(__DIR__, 2) . '/dbNorthwind.sql';
                if (is_file($sqlFile)) {
                    $sql = file_get_contents($sqlFile);
                    if ($sql) {
                        $pdo->exec($sql);
                    }
                }
            } else {
                $count = (int)$pdo->query("SELECT COUNT(*) FROM tb_users")->fetchColumn();
                if ($count === 0) {
                    $pdo->exec("INSERT INTO tb_users (i_usr_id, i_usr_uname, i_usr_pwd) VALUES
                        (1,'admin','$2y$10$/cvHpJDUQNdxWLG2VsSKheAf2Yw8fpq3M2lohOd9oDqng3fgARrES'),
                        (2,'mango','$2y$10$wDtpk5PU6UFJWqqfWX7gFeb75OLUJH4tFDFfK46RDT0i4iXopoaTu'),
                        (3,'banana','$2y$10$p4NtG5moWE1RMUAupmSBn.bNHn2lD4uavGb9elKO2EG4NRyh/kdPS'),
                        (4,'admincpe','$2y$10$/cvHpJDUQNdxWLG2VsSKheAf2Yw8fpq3M2lohOd9oDqng3fgARrES')");
                }

                // One-time migration from the original demo password to the requested admincpe password.
                $pdo->exec("UPDATE tb_users
                    SET i_usr_pwd = '$2y$10$7XLVCLlFUFgjPwFhJN/X8uAFB/mX1f39r.MRHjr91vqG8A.0Aancm'
                    WHERE i_usr_uname = 'admincpe'
                      AND i_usr_pwd = '$2y$10$/cvHpJDUQNdxWLG2VsSKheAf2Yw8fpq3M2lohOd9oDqng3fgARrES'");
            }
        } catch (\Throwable $e) {
            error_log('Database schema initialization: ' . $e->getMessage());
        }
    }
}
