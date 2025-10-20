<?php
session_start();
include 'users.php'; 


if (!isset($_SESSION['id'])) {
    echo "<p style='text-align:center;margin-top:20px;'>Please <a href='login.php'>login</a> to view your cart.</p>";
    exit;
}


$userId = $_SESSION['id'];
$cart = [];
$total = 0;

$sql = "SELECT * FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cart[] = $row;
    $total += $row['price'];
}


if (isset($_GET['remove'])) {
    $removeId = (int)$_GET['remove'];
    $deleteStmt = $conn->prepare("DELETE FROM orders WHERE id = ? AND user_id = ?");
    $deleteStmt->bind_param("ii", $removeId, $userId);
    $deleteStmt->execute();
    $deleteStmt->close();
    header("Location: cart.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Cart — Delish</title>
<link rel="stylesheet" href="styles.css" />
</head>
<body class="page-body">

<nav class="nav">
  <div class="container nav-inner">
    <a href="index.php" class="brand">
      <div class="logo">D</div>
      <span class="brand-text">Delish</span>
    </a>
    <div class="nav-links">
      <a href="menu.php">Menu</a>
      <a href="cart.php">Cart</a>
      <a href="logoutBackend.php">Logout</a>
    </div>
  </div>
</nav>

<main class="container main-content">
  <h2 class="page-title">Your Cart</h2>

  <?php if (empty($cart)): ?>
      <p>Your cart is empty</p>
  <?php else: ?>
      <?php foreach ($cart as $item): ?>
      <div class="cart-item">
          <div>
              <h4><?= htmlspecialchars($item['item_name']) ?></h4>
              <p>₹<?= $item['price'] ?></p>
          </div>
          <div class="cart-actions">
              <a href="cart.php?remove=<?= $item['id'] ?>" class="btn-sm">Remove</a>
          </div>
      </div>
      <?php endforeach; ?>

      <div class="cart-item">
          <div class="total-price">Total: ₹<?= $total ?></div>
          <a href="menu.php" class="btn-sm">Continue Shopping</a>
      </div>
  <?php endif; ?>
</main>

<footer class="site-footer">
  <div class="container footer-inner">
    <div>© Delish — Beautifully cooked & delivered</div>
  </div>
</footer>

</body>
</html>
