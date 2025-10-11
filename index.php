<?php
require_once 'functions.php';
$categories = fetch_categories();

// Fetch featured products (include image column if it exists)
$stmt = $pdo->query("SELECT p.*, c.name as category_name 
                     FROM products p 
                     JOIN categories c ON p.category_id=c.id 
                     ORDER BY p.created_at DESC 
                     LIMIT 8");
$products = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WELCOME TO E-MART | Affordable Prices</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- Hero Section -->
  <div class="hero">
    <h1>WELCOME TO E-MART</h1>
    <p>Affordable Prices for Everyone</p>
  </div>

  <div class="container">

    <!-- Header -->
    <div class="header">
      <h1><a href="index.php">E-Mart</a></h1>
      <div class="nav">
        <?php foreach($categories as $cat): ?>
          <a href="category.php?id=<?=htmlspecialchars($cat['id'])?>">
            <?=htmlspecialchars($cat['name'])?>
          </a>
        <?php endforeach; ?>
        <a href="cart.php">🛒 Cart</a>
        <?php if (is_owner_logged_in()): ?>
          <a href="admin/admin_panel.php" class="admin-badge">Admin Panel</a>
          <a href="logout.php">Logout</a>
        <?php else: ?>
          <a href="login.php">Owner Login</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Search Bar -->
    <form action="search.php" method="get" class="form-inline">
      <select name="category">
        <option value="">All categories</option>
        <?php foreach($categories as $cat): ?>
          <option value="<?=htmlspecialchars($cat['id'])?>">
            <?=htmlspecialchars($cat['name'])?>
          </option>
        <?php endforeach; ?>
      </select>
      <input type="text" name="q" placeholder="Search products..." />
      <button type="submit">Search</button>
    </form>

    <!-- Featured Products -->
    <h3 style="text-align:center; margin-top:30px;">Featured Products</h3>
    <div class="product-grid">
      <?php foreach($products as $p): ?>
        <div class="card">
          <!-- Show product image (or fallback placeholder) -->
          <?php if (!empty($p['image'])): ?>
            <img src="assets/images/<?=htmlspecialchars($p['image'])?>" alt="<?=htmlspecialchars($p['name'])?>" style="width:100%; height:180px; object-fit:cover;">
          <?php else: ?>
            <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=600&q=80" 
                 alt="Product image" 
                 style="width:100%; height:180px; object-fit:cover;">
          <?php endif; ?>

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

    <!-- Footer -->
    <div class="footer">
      <p>© <?=date('Y')?> E-MART • Built with ❤️ for affordable shopping</p>
    </div>

  </div>

  <script src="assets/js/script.js"></script>
</body>
</html>
