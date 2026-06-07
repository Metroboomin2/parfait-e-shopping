<?php
session_start();

$host = 'localhost';
$dbname = 'parfait_e_shopping';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

define('BASE_URL', 'http://localhost/parfait-e-shopping/');
?>