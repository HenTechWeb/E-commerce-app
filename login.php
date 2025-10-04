<?php
require_once 'functions.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        // store user info in session (without password hash)
        unset($user['password_hash']);
        $_SESSION['user'] = $user;
        header('Location: admin/admin_panel.php');
        exit;
    } else {
        $msg = "Invalid credentials";
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Owner Login</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
<div class="container">
  <h2>Owner Login</h2>
  <?php if($msg) echo "<div style='color:red;'>".htmlspecialchars($msg)."</div>"; ?>
  <form method="post">
    <div><input type="text" name="username" placeholder="Username" required></div>
    <div style="margin-top:8px;"><input type="password" name="password" placeholder="Password" required></div>
    <div style="margin-top:8px;"><button type="submit">Login</button></div>
  </form>
  <p style="margin-top:12px;"><a href="index.php">Back to shop</a></p>
</div>
</body>
</html>
