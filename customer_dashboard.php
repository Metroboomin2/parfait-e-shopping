<?php
require_once 'config.php';
if($_SESSION['role'] != 'customer') { header('Location: login.php'); exit; }
include 'header.php';
$orders = $pdo->prepare("SELECT o.*, p.name as product_name FROM orders o JOIN products p ON o.product_id=p.id WHERE o.customer_id=? ORDER BY o.order_date DESC");
$orders->execute([$_SESSION['user_id']]);
$comments = $pdo->prepare("SELECT c.*, p.name as product_name FROM comments c JOIN products p ON c.product_id=p.id WHERE c.customer_id=?");
$comments->execute([$_SESSION['user_id']]);
?>
<h2>My Account</h2>
<div class="card"><h3>My Orders</h3><?php if($orders->rowCount()==0) echo "<p>No orders yet.</p>"; else { echo "<ul>"; while($o=$orders->fetch()) echo "<li>Order #{$o['id']} - {$o['product_name']} x{$o['quantity']} - {$o['status']}</li>"; echo "</ul>"; } ?></div>
<div class="card"><h3>My Comments</h3><?php if($comments->rowCount()==0) echo "<p>No comments yet.</p>"; else { echo "<ul>"; while($c=$comments->fetch()) echo "<li>On {$c['product_name']}: \"{$c['comment']}\" (Rating: {$c['rating']})</li>"; echo "</ul>"; } ?></div>
<?php include 'footer.php'; ?>