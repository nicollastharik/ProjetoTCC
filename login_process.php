<?php
include 'db.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

if ($user && password_verify($senha, $user['senha'])) {
    // Login successful
    session_start();
    $_SESSION['user_id'] = $user['id'];
    header("Location: index2.html");
    exit();
} else {
    // Login failed
    header("Location: login.php?error=invalid_credentials");
    exit();
}
?>