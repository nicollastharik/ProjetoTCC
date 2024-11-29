<?php
require_once 'db_connect.php';

$sql = "SELECT * FROM postar ORDER BY data_postagem DESC";
$result = $conn->query($sql);

$services = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $services[] = array(
            'user' => $row['nome'],
            'userImage' => '/api/placeholder/48/48', // Placeholder image
            'title' => $row['titulo'],
            'description' => $row['descricao'],
            'area' => $row['area'],
            'price' => $row['preco'],
            'contact' => $row['contato']
        );
    }
}

echo json_encode($services);
$conn->close();
?>