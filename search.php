<?php
require_once 'functions.php';
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$cat = isset($_GET['category']) && is_numeric($_GET['category']) ? intval($_GET['category']) : null;
$params = [];
$sql = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id=c.id WHERE 1=1 ";
if ($q !== '') {
    $sql .= " AND (p.name LIKE ? OR p.description LIKE ?) ";
    $params[] = "%$q%";
    $params[] = "%$q%";
}
if ($cat) {
    $sql .= " AND p.category_id = ? ";
    $params[] = $cat;
}
$sql .= " ORDER BY p.created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();
$categories = fetch_categories();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Search results - Mini E-commerce</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
  <div class="header">
    <h2>Search results</h2>
    <div><a href="index.php">Home</a></div>
  </div>

  <p>Query: <strong><?=htmlspecialchars($q)?></strong></p>
  <div class="product-grid">
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
      <p>No results found.</p>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
