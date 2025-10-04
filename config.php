<?php
// config.php - Docker-ready version using environment variables
$host = getenv('DB_HOST') ?: 'db';        // default to 'db' container
$port = getenv('DB_PORT') ?: 3306;
$dbname = getenv('DB_NAME') ?: 'mini_ecommerce';
$user = getenv('DB_USER') ?: 'ecommerce_user';
$password = getenv('DB_PASSWORD') ?: 'ecommerce_pass';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        $options
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

session_start();
