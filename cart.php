<?php
require_once 'functions.php';
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0.00;
foreach ($cart as $it) $total += $it['price'] * $it['qty'];

if (isset($_POST['remove'])) {
    $remove_id = intval($_POST['remove']);
    unset($_SESSION['cart'][$remove_id]);
    header('Location: cart.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Your Cart - Mini E-commerce</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="header">
    <h2>Your Cart</h2>
    <div><a href="index.php">Continue shopping</a></div>
  </div>

  <?php if (empty($cart)): ?>
    <p>Your cart is empty.</p>
  <?php else: ?>
    <table class="table">
      <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Action</th></tr></thead>
      <tbody>
      <?php foreach ($cart as $it): ?>
        <tr>
          <td><?=htmlspecialchars($it['name'])?></td>
          <td>$<?=number_format($it['price'],2)?></td>
          <td><?=htmlspecialchars($it['qty'])?></td>
          <td>$<?=number_format($it['price'] * $it['qty'],2)?></td>
          <td>
            <form method="post" style="display:inline;">
              <input type="hidden" name="remove" value="<?=htmlspecialchars($it['id'])?>">
              <button type="submit" class="btn-danger">Remove</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>

    <div style="margin-top:12px;">
      <strong>Total: $<?=number_format($total,2)?></strong>
      <a href="checkout.php" style="margin-left:12px;"><button>Proceed to Checkout</button></a>
    </div>
  <?php endif; ?>

</div>
</body>
</html>
