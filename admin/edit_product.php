<?php
require_once '../functions.php';
if (!is_owner_logged_in()) {
    header('Location: ../login.php');
    exit;
}
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();
if (!$p) die('Product not found');
$categories = fetch_categories();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Product</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="container">
  <h2>Edit Product</h2>
  <form action="update_product.php" method="post">
    <input type="hidden" name="id" value="<?=htmlspecialchars($p['id'])?>">
    <div><input type="text" name="name" value="<?=htmlspecialchars($p['name'])?>" required></div>
    <div style="margin-top:6px;"><input type="text" name="description" value="<?=htmlspecialchars($p['description'])?>"></div>
    <div style="margin-top:6px;">
      <input type="number" step="0.01" name="price" value="<?=htmlspecialchars($p['price'])?>" required>
      <input type="number" name="stock" value="<?=htmlspecialchars($p['stock'])?>" style="width:90px;">
      <select name="category_id">
        <?php foreach($categories as $cat): ?>
          <option value="<?=htmlspecialchars($cat['id'])?>" <?= $cat['id'] == $p['category_id'] ? 'selected' : '' ?> ><?=htmlspecialchars($cat['name'])?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div style="margin-top:6px;"><button type="submit">Update Product</button></div>
  </form>
  <p><a href="admin_panel.php">Back</a></p>
</div>
</body>
</html>
