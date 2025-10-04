<?php
require_once '../functions.php';
if (!is_owner_logged_in()) {
    header('Location: ../login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    if ($name === '') {
        die('Name required');
    }
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, stock, category_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $stock, $category_id]);
    header('Location: admin_panel.php');
}
