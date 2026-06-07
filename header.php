<?php if(!isset($noHeader)): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parfait E‑Shopping</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="container header-flex">
        <div class="logo">
            <h1>🛍️ Parfait<span>E‑Shopping</span></h1>
        </div>
        <nav>
            <a href="index.php">Home</a>
            <a href="product_list.php">Products</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <?php if($_SESSION['role'] == 'seller'): ?>
                    <a href="seller_dashboard.php">Seller Panel</a>
                <?php elseif($_SESSION['role'] == 'admin'): ?>
                    <a href="admin_dashboard.php">Admin Panel</a>
                <?php elseif($_SESSION['role'] == 'customer'): ?>
                    <a href="customer_dashboard.php">My Account</a>
                <?php endif; ?>
                <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container">
<?php endif; ?>