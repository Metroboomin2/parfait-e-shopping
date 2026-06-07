<?php
require_once 'config.php';
if($_SESSION['role'] != 'customer') { header('Location: login.php'); exit; }
$product_id = $_GET['product_id'];
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    $stmt = $pdo->prepare("INSERT INTO comments (product_id, customer_id, comment, rating) VALUES (?,?,?,?)");
    $stmt->execute([$product_id, $_SESSION['user_id'], $comment, $rating]);
    header("Location: product_detail.php?id=$product_id");
    exit;
}
include 'header.php';
?>
<div class="card">
    <h2>Write a Review</h2>
    <form method="post">
        <textarea name="comment" rows="5" placeholder="Your feedback..." required></textarea>
        <select name="rating" required>
            <option value="5">★★★★★</option><option value="4">★★★★☆</option>
            <option value="3">★★★☆☆</option><option value="2">★★☆☆☆</option>
            <option value="1">★☆☆☆☆</option>
        </select>
        <button type="submit" class="btn">Submit</button>
    </form>
</div>
<?php include 'footer.php'; ?>
