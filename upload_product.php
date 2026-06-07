<?php
require_once 'config.php';
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seller') { header('Location: login.php'); exit; }
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("SELECT photo, document FROM products WHERE id=? AND seller_id=?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    $prod = $stmt->fetch();
    if($prod) {
        if(file_exists("uploads/".$prod['photo'])) unlink("uploads/".$prod['photo']);
        if($prod['document'] && file_exists("uploads/".$prod['document'])) unlink("uploads/".$prod['document']);
        $pdo->prepare("DELETE FROM products WHERE id=?")->execute([$id]);
    }
    header('Location: seller_dashboard.php');
    exit;
}
$msg = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $photo = $_FILES['photo'];
    $document = $_FILES['document'];
    if(!is_dir('uploads')) mkdir('uploads');
    $photoName = time().'_'.basename($photo['name']);
    move_uploaded_file($photo['tmp_name'], "uploads/$photoName");
    $docName = null;
    if($document['error'] == 0) {
        $docName = time().'_'.basename($document['name']);
        move_uploaded_file($document['tmp_name'], "uploads/$docName");
    }
    $stmt = $pdo->prepare("INSERT INTO products (seller_id, name, description, price, photo, document, location) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([$_SESSION['user_id'], $name, $desc, $price, $photoName, $docName, $location]);
    $msg = "Product uploaded successfully!";
}
include 'header.php';
?>
<div class="card">
    <h2>Upload New Product</h2>
    <?php if($msg) echo "<div class='message success'>$msg</div>"; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Product Name" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price (USD)" required>
        <input type="text" name="location" placeholder="Location" required>
        <label>Product Photo:</label>
        <input type="file" name="photo" accept="image/*" required id="photo">
        <img id="photo-preview" style="max-width:200px; display:none;">
        <label>Optional Document:</label>
        <input type="file" name="document">
        <button type="submit" class="btn">Upload</button>
    </form>
</div>
<?php include 'footer.php'; ?>