<?php
declare(strict_types=1);

$envFile = dirname(__DIR__) . '/.env';
if (is_file($envFile) && is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim(trim($value), "\"'");
        if ($key !== '' && getenv($key) === false) putenv($key . '=' . $value);
    }
}

// Auto-detect connection URL from platforms like Railway / Render
$dbUrl = getenv('DATABASE_URL') ?: (getenv('MYSQL_URL') ?: getenv('MYSQL_PRIVATE_URL'));
$urlHost = null; $urlPort = null; $urlUser = null; $urlPass = null; $urlName = null;
if ($dbUrl) {
    $parsed = parse_url($dbUrl);
    if ($parsed) {
        $urlHost = $parsed['host'] ?? null;
        $urlPort = isset($parsed['port']) ? (int)$parsed['port'] : null;
        $urlUser = isset($parsed['user']) ? urldecode($parsed['user']) : null;
        $urlPass = isset($parsed['pass']) ? urldecode($parsed['pass']) : null;
        $urlName = isset($parsed['path']) ? ltrim($parsed['path'], '/') : null;
    }
}

return [
    'db' => [
        'host' => getenv('DB_HOST') ?: ($urlHost ?: (getenv('MYSQLHOST') ?: '127.0.0.1')),
        'port' => (int)(getenv('DB_PORT') ?: ($urlPort ?: (getenv('MYSQLPORT') ?: 3306))),
        'name' => getenv('DB_NAME') ?: ($urlName ?: (getenv('MYSQLDATABASE') ?: 'railway')),
        'user' => getenv('DB_USER') ?: ($urlUser ?: (getenv('MYSQLUSER') ?: 'root')),
        'pass' => getenv('DB_PASS') ?: ($urlPass ?: (getenv('MYSQLPASSWORD') ?: (getenv('MYSQL_ROOT_PASSWORD') ?: ''))),
        'charset' => 'utf8mb4',
    ],
    'jwt_secret' => getenv('JWT_SECRET') ?: 'northwind-default-bms-secret-key-replace-if-needed-32chars',
    'token_ttl' => 28800,
];

