<?php
// config.php
$db_host = 'localhost';
$db_user = 'root'; // Altere para seu usuário do MySQL
$db_pass = ''; // Altere para sua senha do MySQL
$db_name = 'mydatabase';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

session_start();

function getUsuarioId() {
    return isset($_SESSION['id']) ? $_SESSION['id'] : null;
}
?>
