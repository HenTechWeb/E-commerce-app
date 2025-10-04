<?php
require_once 'functions.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) die('Product ID missing');
$p = find_product($id);
if (!$p) die('Product not found');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=htmlspecialchars($p['name'])?> - Mini E-commerce</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="header">
    <h2><?=htmlspecialchars($p['name'])?></h2>
    <div><a href="index.php">Home</a> | <a href="cart.php">Cart</a></div>
  </div>

  <div style="display:flex; gap:20px;">
    <div style="flex:1;">
      <div class="card">
        <h3><?=htmlspecialchars($p['name'])?></h3>
        <p><?=nl2br(htmlspecialchars($p['description']))?></p>
        <div class="price">$<?=number_format($p['price'],2)?></div>
        <div>Category: <?=htmlspecialchars($p['category_name'])?></div>
        <div>Stock: <?=htmlspecialchars($p['stock'])?></div>

        <form action="add_to_cart.php" method="post" style="margin-top:10px;">
          <input type="hidden" name="product_id" value="<?=htmlspecialchars($p['id'])?>">
          <input type="number" name="qty" value="1" min="1" max="<?=htmlspecialchars($p['stock'])?>">
          <button type="submit">Add to Cart</button>
        </form>
      </div>
    </div>
  </div>

</div>
</body>
</html>
