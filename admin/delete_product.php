<?php
require_once '../functions.php';
if (!is_owner_logged_in()) {
    header('Location: ../login.php');
    exit;
}
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: admin_panel.php');
