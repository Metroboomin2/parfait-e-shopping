<?php
require_once 'config.php';
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') { header('Location: login.php'); exit; }
include 'header.php';
$seller_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE seller_id = ? ORDER BY created_at DESC");
$stmt->execute([$seller_id]);
$products = $stmt->fetchAll();
?>
<h2>Seller Dashboard</h2>
<a href="upload_product.php" class="btn btn-success">+ Add New Product</a>
<?php if(count($products) == 0): ?>
    <p>No products yet.</p>
<?php else: ?>
    <table border="1" cellpadding="10" style="width:100%; margin-top:20px; border-collapse:collapse">
        <tr style="background:#2c3e50; color:white"><th>Photo</th><th>Name</th><th>Price</th><th>Location</th><th>Actions</th></tr>
        <?php foreach($products as $p): ?>
        <tr>
            <td><img src="uploads/<?php echo $p['photo']; ?>" width="50"></td>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td>$<?php echo number_format($p['price'], 2); ?></td>
            <td><?php echo htmlspecialchars($p['location']); ?></td>
            <td>
                <a href="edit_product.php?id=<?php echo $p['id']; ?>" class="btn">Edit</a>
                <a href="upload_product.php?delete=<?php echo $p['id']; ?>" class="btn btn-danger delete-confirm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
<?php include 'footer.php'; ?>