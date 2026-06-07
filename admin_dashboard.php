<?php
require_once 'config.php';
if($_SESSION['role'] != 'admin') { header('Location: login.php'); exit; }
include 'header.php';
$users = $pdo->query("SELECT * FROM users")->fetchAll();
$products = $pdo->query("SELECT p.*, u.username as seller FROM products p JOIN users u ON p.seller_id = u.id")->fetchAll();
$orders = $pdo->query("SELECT o.*, p.name as product_name, u.username as customer FROM orders o JOIN products p ON o.product_id=p.id JOIN users u ON o.customer_id=u.id")->fetchAll();
?>
<h2>Admin Dashboard</h2>
<div class="card"><h3>Users</h3><table border="1" width="100%"><?php foreach($users as $u) echo "<tr><td>{$u['id']}</td><td>{$u['username']}</td><td>{$u['email']}</td><td>{$u['role']}</td><td>{$u['location']}</td></tr>"; ?></table></div>
<div class="card"><h3>Products</h3><table border="1" width="100%"><?php foreach($products as $p) echo "<tr><td>{$p['id']}</td><td>{$p['name']}</td><td>{$p['seller']}</td><td>\${$p['price']}</td><td>{$p['location']}</td></tr>"; ?></table></div>
<div class="card"><h3>Orders</h3><table border="1" width="100%"><?php foreach($orders as $o) echo "<tr><td>{$o['id']}</td><td>{$o['product_name']}</td><td>{$o['customer']}</td><td>{$o['quantity']}</td><td>{$o['status']}</td></tr>"; ?></table></div>
<?php include 'footer.php'; ?>