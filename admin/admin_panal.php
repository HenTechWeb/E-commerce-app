<?php
require_once '../functions.php';
if (!is_owner_logged_in()) {
    header('Location: ../login.php');
    exit;
}
$categories = fetch_categories();

// fetch products
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id=c.id ORDER BY p.id DESC");
$products = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Panel</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="container">
  <div class="header">
    <h2>Admin Panel</h2>
    <div><a href="../index.php">View Shop</a> | <a href="../logout.php">Logout</a></div>
  </div>

  <h3>Add new product</h3>
  <form action="add_product.php" method="post">
    <div><input type="text" name="name" placeholder="Product name" required></div>
    <div style="margin-top:6px;"><input type="text" name="description" placeholder="Short description"></div>
    <div style="margin-top:6px;">
      <input type="number" step="0.01" name="price" placeholder="Price" required>
      <input type="number" name="stock" placeholder="Stock" value="10" style="width:90px;">
      <select name="category_id">
        <?php foreach($categories as $cat): ?>
          <option value="<?=htmlspecialchars($cat['id'])?>"><?=htmlspecialchars($cat['name'])?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div style="margin-top:6px;"><button type="submit">Add Product</button></div>
  </form>

  <h3 style="margin-top:18px;">Existing products</h3>
  <table class="table">
    <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach($products as $p): ?>
        <tr>
          <td><?=htmlspecialchars($p['id'])?></td>
          <td><?=htmlspecialchars($p['name'])?></td>
          <td><?=htmlspecialchars($p['category_name'])?></td>
          <td>$<?=number_format($p['price'],2)?></td>
          <td><?=htmlspecialchars($p['stock'])?></td>
          <td>
            <a href="edit_product.php?id=<?=htmlspecialchars($p['id'])?>">Edit</a> |
            <a href="delete_product.php?id=<?=htmlspecialchars($p['id'])?>" onclick="return confirm('Delete product?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>
</body>
</html>
