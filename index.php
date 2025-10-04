<?php
require_once 'functions.php';
$categories = fetch_categories();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Mini E-commerce</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container">
    <div class="header">
      <h1><a href="index.php">Mini E-commerce</a></h1>
      <div>
        <span class="nav">
          <?php foreach($categories as $cat): ?>
            <a href="category.php?id=<?=htmlspecialchars($cat['id'])?>"><?=htmlspecialchars($cat['name'])?></a>
          <?php endforeach; ?>
          <a href="cart.php">Cart</a>
          <?php if (is_owner_logged_in()): ?>
            <a href="admin/admin_panel.php" class="admin-badge">Admin Panel</a>
            <a href="logout.php">Logout</a>
          <?php else: ?>
            <a href="login.php">Owner Login</a>
          <?php endif; ?>
        </span>
      </div>
    </div>

    <form action="search.php" method="get" class="form-inline">
      <select name="category">
        <option value="">All categories</option>
        <?php foreach($categories as $cat): ?>
          <option value="<?=htmlspecialchars($cat['id'])?>"><?=htmlspecialchars($cat['name'])?></option>
        <?php endforeach; ?>
      </select>
      <input type="text" name="q" placeholder="Search products..." />
      <button type="submit">Search</button>
    </form>

    <h3 style="margin-top:18px;">Featured Products</h3>
    <?php
    $stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id=c.id ORDER BY p.created_at DESC LIMIT 8");
    $products = $stmt->fetchAll();
    ?>
    <div class="product-grid">
      <?php foreach($products as $p): ?>
        <div class="card">
          <h4><?=htmlspecialchars($p['name'])?></h4>
          <div><?=htmlspecialchars(substr($p['description'],0,80))?>...</div>
          <div class="price">$<?=number_format($p['price'],2)?></div>
          <div style="margin-top:8px;">
            <a href="product.php?id=<?=htmlspecialchars($p['id'])?>">View</a>
            <form style="display:inline" action="add_to_cart.php" method="post">
              <input type="hidden" name="product_id" value="<?=htmlspecialchars($p['id'])?>">
              <input type="number" name="qty" value="1" min="1" style="width:60px;">
              <button type="submit">Add</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="footer">
      <p>Simple mini e-commerce demo • Manage DB with phpMyAdmin</p>
    </div>
  </div>
<script src="assets/js/script.js"></script>
</body>
</html>
