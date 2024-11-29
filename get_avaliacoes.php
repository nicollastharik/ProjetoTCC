<?php
header('Content-Type: application/json');
error_reporting(0);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Conexão falhou']));
}

$service_id = isset($_GET['service_id']) ? (int)$_GET['service_id'] : 0;

$sql = "SELECT COUNT(*) as count FROM avaliacoes WHERE service_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(['error' => 'Erro na preparação da query']));
}

$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc()['count'];

echo json_encode(['count' => $count]);

$stmt->close();
$conn->close();
?>