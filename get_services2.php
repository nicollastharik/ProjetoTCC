<?php
header('Content-Type: application/json');
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexão falhou: ' . $conn->connect_error]));
}

$sql = "SELECT * FROM services ORDER BY id DESC";
$result = $conn->query($sql);

$services = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $services[] = [
            'id' => $row['id'],
            'user' => $row['user_name'] ?? 'Usuário',
            'userImage' => $row['user_image'] ?? 'placeholder.jpg',
            'title' => $row['title'],
            'description' => $row['description'],
            'area' => $row['area'],
            'price' => $row['price'],
            'contact' => $row['contact']
        ];
    }
}

echo json_encode($services);
$conn->close();
?>