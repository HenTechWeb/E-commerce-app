<?php
require_once '../functions.php';
if (!is_owner_logged_in()) {
    header('Location: ../login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, stock=?, category_id=? WHERE id=?");
    $stmt->execute([$name, $description, $price, $stock, $category_id, $id]);
    header('Location: admin_panel.php');
}
