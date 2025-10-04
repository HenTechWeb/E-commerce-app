<?php
require_once 'functions.php';
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}
$total = 0;
foreach ($cart as $it) $total += $it['price'] * $it['qty'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In production, you'd collect customer data & payment — this is simplified
    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
        // user_id null for guest checkout
        $stmt->execute([null, $total]);
        $order_id = $pdo->lastInsertId();

        $insertItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, qty, price) VALUES (?, ?, ?, ?)");
        $updateStock = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");

        foreach ($cart as $it) {
            $insertItem->execute([$order_id, $it['id'], $it['qty'], $it['price']]);
            $updateStock->execute([$it['qty'], $it['id'], $it['qty']]);
        }
        $pdo->commit();

        // Clear cart
        unset($_SESSION['cart']);
        $success = true;
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = $e->getMessage();
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Checkout - Mini E-commerce</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="header">
    <h2>Checkout</h2>
    <div><a href="cart.php">Back to cart</a></div>
  </div>

  <?php if (!empty($success)): ?>
    <div class="card">
      <h3>Thank you — your order has been placed!</h3>
      <p>Order ID: <?=htmlspecialchars($order_id)?></p>
      <a href="index.php">Return to shop</a>
    </div>
  <?php else: ?>
    <?php if (!empty($error)): ?>
      <div style="color:red;">Error: <?=htmlspecialchars($error)?></div>
    <?php endif; ?>
    <div class="card">
      <p>Total: <strong>$<?=number_format($total,2)?></strong></p>
      <form method="post">
        <p>This demo uses a simplified checkout (no payment provider). Click below to complete the order.</p>
        <button type="submit">Place Order</button>
      </form>
    </div>
  <?php endif; ?>

</div>
</body>
</html>
