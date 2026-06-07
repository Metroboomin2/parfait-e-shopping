<?php
require_once 'config.php';
if($_SESSION['role'] != 'seller') exit;
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=? AND seller_id=?");
$stmt->execute([$id, $_SESSION['user_id']]);
$product = $stmt->fetch();
if(!$product) { header('Location: seller_dashboard.php'); exit; }
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, location=? WHERE id=?");
    $update->execute([$_POST['name'], $_POST['description'], $_POST['price'], $_POST['location'], $id]);
    header('Location: seller_dashboard.php');
    exit;
}
include 'header.php';
?>
<div class="card">
    <h2>Edit Product</h2>
    <form method="post">
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        <textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
        <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
        <input type="text" name="location" value="<?php echo htmlspecialchars($product['location']); ?>" required>
        <button type="submit" class="btn">Update</button>
    </form>
</div>
<?php include 'footer.php'; ?>