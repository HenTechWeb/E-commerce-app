<?php
require_once 'functions.php';
$categories = fetch_categories();
$cat_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($cat_id) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id=?");
    $stmt->execute([$cat_id]);
    $category = $stmt->fetch();
    if (!$category) {
        die("Category not found");
    }
    $title = $category['name'];
    if ($search) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND (name LIKE ? OR description LIKE ?) ORDER BY created_at DESC");
        $stmt->execute([$cat_id, "%$search%", "%$search%"]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ? ORDER BY created_at DESC");
        $stmt->execute([$cat_id]);
    }
    $products = $stmt->fetchAll();
} else {
    die("Category ID missing");
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title><?=htmlspecialchars($title)?> - Mini E-commerce</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="header">
    <h2><?=htmlspecialchars($title)?></h2>
    <div><a href="index.php">Home</a> | <a href="cart.php">Cart</a></div>
  </div>

  <form action="category.php" method="get" class="form-inline">
    <input type="hidden" name="id" value="<?=htmlspecialchars($cat_id)?>">
    <input type="text" name="q" placeholder="Search in <?=htmlspecialchars($title)?>" value="<?=htmlspecialchars($search)?>">
    <button type="submit">Search</button>
  </form>

  <div class="product-grid" style="margin-top:12px;">
    <?php if ($products): foreach($products as $p): ?>
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
    <?php endforeach; else: ?>
      <p>No products found in this category.</p>
    <?php endif; ?>
  </div>

</div>
</body>
</html>
