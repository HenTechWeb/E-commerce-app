<?php
// functions.php
require_once 'config.php';

function fetch_categories() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
    return $stmt->fetchAll();
}

function find_product($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id=c.id WHERE p.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function is_owner_logged_in() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'owner';
}
