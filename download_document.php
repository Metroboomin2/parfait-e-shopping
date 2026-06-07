<?php
require_once 'config.php';
if(!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$file = $_GET['file'];
$product_id = $_GET['product_id'];
$stmt = $pdo->prepare("SELECT document FROM products WHERE id=?");
$stmt->execute([$product_id]);
$prod = $stmt->fetch();
if($prod && $prod['document'] == $file) {
    $filepath = "uploads/" . $file;
    if(file_exists($filepath)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        readfile($filepath);
        exit;
    }
}
die("File not found.");