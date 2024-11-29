<?php
// buscar_comentarios.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
require_once 'config.php';

try {
    if (!isset($_GET['service_id'])) {
        throw new Exception('ID do serviço não fornecido');
    }

    $service_id = intval($_GET['service_id']);
    
    $stmt = $pdo->prepare("SELECT user_name, comment_text, created_at 
                          FROM comments 
                          WHERE service_id = ? 
                          ORDER BY created_at DESC");
    
    $stmt->execute([$service_id]);
    $comentarios = $stmt->fetchAll();

    // Formata os comentários
    $comentarios_formatados = array_map(function($row) {
        return [
            'usuario_nome' => $row['user_name'],
            'comentario' => $row['comment_text'],
            'data_comentario' => date('d/m/Y H:i', strtotime($row['created_at']))
        ];
    }, $comentarios);

    echo json_encode([
        'success' => true,
        'data' => $comentarios_formatados
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>