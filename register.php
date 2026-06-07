<?php
require_once 'config.php';
if(isset($_SESSION['user_id'])) header('Location: index.php');
$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $location = $_POST['location'];
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, location) VALUES (?,?,?,?,?)");
    try {
        $stmt->execute([$username, $email, $password, $role, $location]);
        header('Location: login.php');
        exit;
    } catch(PDOException $e) {
        $error = "Username or email already exists.";
    }
}
include 'header.php';
?>
<div class="card">
    <h2>Register</h2>
    <?php if($error) echo "<div class='message error'>$error</div>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="customer">Customer</option>
            <option value="seller">Seller</option>
        </select>
        <input type="text" name="location" placeholder="Your Location">
        <button type="submit" class="btn">Register</button>
    </form>
</div>
<?php include 'footer.php'; ?>