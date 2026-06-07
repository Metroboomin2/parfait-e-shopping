<?php
require_once 'config.php';
include 'header.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT p.*, u.username as seller_name FROM products p JOIN users u ON p.seller_id = u.id WHERE p.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();
if(!$product) { echo "<div class='message error'>Product not found.</div>"; include 'footer.php'; exit; }
$commentStmt = $pdo->prepare("SELECT c.*, u.username FROM comments c JOIN users u ON c.customer_id = u.id WHERE c.product_id = ? ORDER BY c.created_at DESC");
$commentStmt->execute([$id]);
$comments = $commentStmt->fetchAll();
?>
<div class="card">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <img src="uploads/<?php echo $product['photo']; ?>" style="max-width:100%; border-radius:8px;">
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
    <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
    <p><strong>Seller:</strong> <?php echo htmlspecialchars($product['seller_name']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($product['location']); ?></p>
    <?php if($product['document']): ?>
        <a href="download_document.php?file=<?php echo urlencode($product['document']); ?>&product_id=<?php echo $product['id']; ?>" class="btn btn-success">📎 Download Document</a>
    <?php endif; ?>
    <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'customer'): ?>
        <a href="place_order.php?product_id=<?php echo $product['id']; ?>" class="btn">🛒 Place Order</a>
        <a href="comment.php?product_id=<?php echo $product['id']; ?>" class="btn btn-warning">✍️ Write a Comment</a>
    <?php endif; ?>
</div>
<h3>Customer Reviews</h3>
<?php foreach($comments as $c): ?>
    <div class="card">
        <strong><?php echo htmlspecialchars($c['username']); ?></strong> 
        <span>Rating: <?php echo str_repeat('★', $c['rating']) . str_repeat('☆', 5-$c['rating']); ?></span>
        <p><?php echo nl2br(htmlspecialchars($c['comment'])); ?></p>
        <small><?php echo $c['created_at']; ?></small>
    </div>
<?php endforeach; ?>
<?php include 'footer.php'; ?>