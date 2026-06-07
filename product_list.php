<?php
require_once 'config.php';
include 'header.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT * FROM products WHERE name LIKE ? ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$search%"]);
$products = $stmt->fetchAll();
?>
<h2>All Products</h2>
<form method="get" style="margin-bottom:20px">
    <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
    <button type="submit" class="btn">Search</button>
</form>
<div class="product-grid">
<?php foreach($products as $p): ?>
    <div class="product-card">
        <img src="uploads/<?php echo $p['photo']; ?>" alt="<?php echo $p['name']; ?>">
        <div class="product-info">
            <h3><?php echo htmlspecialchars($p['name']); ?></h3>
            <p>$<?php echo number_format($p['price'], 2); ?></p>
            <p><small>📍 <?php echo htmlspecialchars($p['location']); ?></small></p>
            <a href="product_detail.php?id=<?php echo $p['id']; ?>" class="btn">View Details</a>
        </div>
    </div>
<?php endforeach; ?>
</div>
<?php include 'footer.php'; ?>