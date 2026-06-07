<?php
require_once 'config.php';
include 'header.php';
?>
<div class="card">
    <h2>Welcome to Parfait E‑Shopping</h2>
    <p>Your trusted marketplace. Sell, buy, and review products.</p>
    <?php if(!isset($_SESSION['user_id'])): ?>
        <a href="register.php" class="btn">Register Now</a>
        <a href="login.php" class="btn">Login</a>
    <?php else: ?>
        <a href="product_list.php" class="btn">Start Shopping</a>
    <?php endif; ?>
</div>
<h3>Latest Products</h3>
<div class="product-grid">
    <?php
    $stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 6");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='product-card'>";
        echo "<img src='uploads/{$row['photo']}' alt='{$row['name']}'>";
        echo "<div class='product-info'><h3>{$row['name']}</h3><p>$" . number_format($row['price'], 2) . "</p><a href='product_detail.php?id={$row['id']}' class='btn'>View</a></div>";
        echo "</div>";
    }
    ?>
</div>
<?php include 'footer.php'; ?>