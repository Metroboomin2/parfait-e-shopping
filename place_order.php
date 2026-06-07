<?php
require_once 'config.php';
if($_SESSION['role'] != 'customer') { header('Location: login.php'); exit; }
$product_id = $_GET['product_id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();
if(!$product) die("Product not found");
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quantity = $_POST['quantity'];
    $orderStmt = $pdo->prepare("INSERT INTO orders (product_id, customer_id, quantity) VALUES (?,?,?)");
    $orderStmt->execute([$product_id, $_SESSION['user_id'], $quantity]);
    echo "<div class='message success'>Order placed!</div>";
    header('refresh:2;url=product_detail.php?id='.$product_id);
    exit;
}
include 'header.php';
?>
<div class="card">
    <h2>Order: <?php echo htmlspecialchars($product['name']); ?></h2>
    <p>Price: $<?php echo number_format($product['price'], 2); ?> per unit</p>
    <form method="post">
        <label>Quantity:</label>
        <input type="number" name="quantity" min="1" value="1" required>
        <button type="submit" class="btn">Confirm Order</button>
    </form>
</div>
<?php include 'footer.php'; ?>