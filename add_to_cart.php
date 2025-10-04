<?php
require_once 'functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$qty = isset($_POST['qty']) ? max(1,intval($_POST['qty'])) : 1;

$stmt = $pdo->prepare("SELECT id, name, price, stock FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$p = $stmt->fetch();
if (!$p) {
    die('Product not found');
}
if ($qty > $p['stock']) $qty = $p['stock'];

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['qty'] += $qty;
} else {
    $_SESSION['cart'][$product_id] = [
        'id' => $p['id'],
        'name' => $p['name'],
        'price' => $p['price'],
        'qty' => $qty
    ];
}
header('Location: cart.php');
exit;
