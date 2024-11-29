<?php
// salvar_comentario.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
require_once 'config.php';

try {
    // Verifica se recebeu dados
    $input = file_get_contents('php://input');
    if (!$input) {
        throw new Exception('Nenhum dado recebido');
    }

    // Decodifica JSON
    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Erro ao decodificar JSON: ' . json_last_error_msg());
    }

    // Verifica campos obrigatórios
    if (!isset($data['service_id']) || !isset($data['comentario'])) {
        throw new Exception('Dados incompletos');
    }

    // Prepara e executa a query
    $stmt = $pdo->prepare("INSERT INTO comments (service_id, user_name, comment_text) VALUES (?, ?, ?)");
    
    $service_id = intval($data['service_id']);
    $usuario_nome = "Usuário"; // Você pode modificar para usar o nome do usuário logado
    $comentario = trim($data['comentario']);
    
    $stmt->execute([$service_id, $usuario_nome, $comentario]);

    echo json_encode([
        'success' => true,
        'message' => 'Comentário salvo com sucesso'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>