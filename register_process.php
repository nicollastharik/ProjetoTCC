<?php
include 'db.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$cnpj = $_POST['cnpj'];
$nome_emp = $_POST['nome_emp'];
$cpf = $_POST['cpf'];
$data_nascimento = $_POST['data_nascimento'];

$sql = "INSERT INTO users (nome, email, senha, cnpj, nome_emp, cpf, data_nascimento) 
        VALUES (:nome, :email, :senha, :cnpj, :nome_emp, :cpf, :data_nascimento)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':senha' => $senha,
        ':cnpj' => $cnpj,
        ':nome_emp' => $nome_emp,
        ':cpf' => $cpf,
        ':data_nascimento' => $data_nascimento
    ]);
    
    // Se chegou aqui, o registro foi bem-sucedido
    header("Location: index2.html");
    exit();
} catch(PDOException $e) {
    echo "Erro ao registrar: " . $e->getMessage();
}
?>