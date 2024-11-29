<?php
$servername = "localhost";
$username = "root";  // Assumindo que você está usando o usuário padrão do XAMPP
$password = "";      // Senha em branco é o padrão para o XAMPP
$dbname = "mydatabase";

// Criar conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexão
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}
?>

