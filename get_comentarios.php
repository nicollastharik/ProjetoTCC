<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexão falhou']));
}

$service_id = $_GET['service_id'];

$sql = "SELECT * FROM comentarios WHERE service_id = ? ORDER BY data_comentario DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();

$comentarios = [];
while ($row = $result->fetch_assoc()) {
    $row['data_comentario'] = date('d/m/Y H:i', strtotime($row['data_comentario']));
    $comentarios[] = $row;
}

echo json_encode($comentarios);

$stmt->close();
$conn->close();
?>