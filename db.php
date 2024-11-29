<?php
$host = 'localhost'; // ou o endereço do seu servidor de banco de dados
$db = 'mydatabase';
$user = 'root'; // seu usuário de banco de dados
$pass = ''; // sua senha de banco de dados

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>