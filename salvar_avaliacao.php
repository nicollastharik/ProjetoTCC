<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

if (!isset($_SESSION['cpf'])) {
    die(json_encode([
        'success' => false,
        'error' => 'Usuário não logado'
    ]));
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode([
        'success' => false,
        'error' => 'Conexão falhou'
    ]));
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['service_id'])) {
    die(json_encode([
        'success' => false,
        'error' => 'Dados inválidos'
    ]));
}

$service_id = $data['service_id'];
$usuario_nome = $_SESSION['cpf'];

// Primeiro verifica se já existe
$check_sql = "SELECT id FROM avaliacoes WHERE service_id = ? AND usuario_nome = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("is", $service_id, $usuario_nome);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    // Se existe, remove
    $sql = "DELETE FROM avaliacoes WHERE service_id = ? AND usuario_nome = ?";
} else {
    // Se não existe, adiciona
    $sql = "INSERT INTO avaliacoes (service_id, usuario_nome) VALUES (?, ?)";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $service_id, $usuario_nome);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Erro ao processar avaliação'
    ]);
}

$stmt->close();
$check_stmt->close();
$conn->close();
?>