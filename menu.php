<?php
session_start();
include 'users.php'; 


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


$added_item = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];

   
    if (isset($_SESSION['id'])) {
        $uid = $_SESSION['id'];
        $stmt = $conn->prepare("INSERT INTO orders (user_id, item_name, price) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $uid, $item_name, $item_price);
        $stmt->execute();
        $stmt->close();
        $added_item = $item_name;
    } else {
        
        $cart_item = ['name' => $item_name, 'price' => $item_price];
        $_SESSION['cart'][] = $cart_item;
        $added_item = $item_name;
    }
}


$category_filter = $_GET['category'] ?? 'all';


$menu_items = [
    ['name'=>'Classic Burger','price'=>199,'category'=>'burgers','img'=>'https://images.unsplash.com/photo-1550547660-d9450f859349?w=800&q=80'],
    ['name'=>'Cheese Burst Burger','price'=>249,'category'=>'burgers','img'=>'https://images.unsplash.com/photo-1603893662172-99ed0cea2a08?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Y2hlZXNlJTIwYnVyZ2VyfGVufDB8fDB8fHww'],
    ['name'=>'Margherita Pizza','price'=>299,'category'=>'pizza','img'=>'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
    ['name'=>'Pepperoni Pizza','price'=>349,'category'=>'pizza','img'=>'https://images.unsplash.com/photo-1542282811-943ef1a977c3?q=80&w=2072&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
    ['name'=>'Spicy Pasta','price'=>179,'category'=>'pasta','img'=>'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&q=80'],
    ['name'=>'White Sauce Pasta','price'=>199,'category'=>'pasta','img'=>'https://images.unsplash.com/photo-1525755662778-989d0524087e?w=800&q=80'],
    ['name'=>'Sushi Platter','price'=>399,'category'=>'sushi','img'=>'https://images.unsplash.com/photo-1546069901-eacef0df6022?w=800&q=80'],
    ['name'=>'California Roll','price'=>249,'category'=>'sushi','img'=>'https://images.unsplash.com/photo-1721710363252-9d4ac32b0015?q=80&w=987&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
    ['name'=>'Veggie Bowl','price'=>149,'category'=>'salads','img'=>'https://images.unsplash.com/photo-1543353071-087092ec393a?w=800&q=80'],
    ['name'=>'Caesar Salad','price'=>159,'category'=>'salads','img'=>'https://images.unsplash.com/photo-1551218808-94e220e084d2?w=800&q=80']
];


$filtered_items = array_filter($menu_items, function($item) use ($category_filter) {
    return $category_filter === 'all' || $item['category'] === $category_filter;
});
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Menu — Delish</title>
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
      <?php if (isset($_SESSION['id'])): ?>
        <a href="logoutBackend.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Account</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<main class="container main-content">
  <h2 class="page-title">Our Menu</h2>

  <div class="categories">
  <?php
  $categories = [
    'all' => '🔥 All',
    'burgers' => '🍔 Burgers',
    'pizza' => '🍕 Pizza',
    'pasta' => '🍝 Pasta',
    'sushi' => '🍣 Sushi',
    'salads' => '🥗 Salads'
  ];
  foreach ($categories as $key => $label):
      $activeClass = ($category_filter === $key) ? 'active' : '';
  ?>
    <a href="menu.php?category=<?= $key ?>" class="category <?= $activeClass ?>"><?= $label ?></a>
  <?php endforeach; ?>
  </div>

  <div class="menu-grid">
  <?php foreach ($filtered_items as $item): ?>
    <article class="menu-item">
      <img src="<?= $item['img'] ?>" alt="<?= htmlspecialchars($item['name']) ?>" />
      <div class="menu-body">
        <h3><?= htmlspecialchars($item['name']) ?></h3>
        <p class="muted">Delicious food</p>
        <div class="menu-foot">
          <div class="price">₹<?= $item['price'] ?></div>
          <form method="POST">
              <input type="hidden" name="item_name" value="<?= htmlspecialchars($item['name']) ?>">
              <input type="hidden" name="item_price" value="<?= $item['price'] ?>">
              <?php $addedClass = ($added_item === $item['name']) ? 'added' : ''; ?>
              <button type="submit" class="btn btn-primary btn-sm <?= $addedClass ?>">Add</button>
          </form>
        </div>
      </div>
    </article>
  <?php endforeach; ?>
  </div>
</main>

<footer class="site-footer">
  <div class="container footer-inner">
    <div>© Delish — Beautifully cooked & delivered</div>
  </div>
</footer>

</body>
</html>
