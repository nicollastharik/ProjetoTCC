<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

// Cria uma conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    // Validação básica
    if (empty($cpf) || empty($senha)) {
        echo "CPF e senha são obrigatórios.";
        exit();
    }

    // Consulta melhorada para verificar todos os dados do usuário
    $sql = "SELECT id, cpf, senha FROM users WHERE cpf = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "CPF não encontrado.";
    } else {
        $user = $result->fetch_assoc();
        
        // Verifica se a senha está correta
        if (password_verify($senha, $user['senha'])) {
            // Inicia a sessão
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['cpf'] = $user['cpf'];
            
            // Redireciona para a página principal
            header("Location: index2.html");
            exit(); // Importante adicionar exit() após o redirecionamento
        } else {
            // Para debug: mostra os valores (remover em produção)
            echo "Senha incorreta.<br>";
            echo "Senha fornecida: " . $senha . "<br>";
            echo "Hash armazenado: " . $user['senha'] . "<br>";
        }
    }

    $stmt->close();
}

$conn->close();
?>