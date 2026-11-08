<?php
declare(strict_types=1);

/**
 * Compatibility PDO connection imported from tachibana777/Web-app.
 * The active Web-app-II API uses api/config.php and api/src/Database.php.
 */
$servername = getenv('MYSQLHOST') ?: (getenv('DB_HOST') ?: 'localhost');
$port = getenv('MYSQLPORT') ?: (getenv('DB_PORT') ?: 3306);
$username = getenv('MYSQLUSER') ?: (getenv('DB_USER') ?: 'root');
$password = getenv('MYSQLPASSWORD') ?: (getenv('DB_PASS') ?: 'root');
$dbname = getenv('MYSQLDATABASE') ?: (getenv('DB_NAME') ?: 'db_northwind');

try {
    $conn = new PDO(
        "mysql:host={$servername};port={$port};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status' => false, 'error' => 'Database connection failed'], JSON_UNESCAPED_UNICODE);
    exit;
}
