<?php
include 'db.php';

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'] ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;
$cnpj = $_POST['cnpj'];
$nome_emp = $_POST['nome_emp'];
$cpf = $_POST['cpf'];
$data_nascimento = $_POST['data_nascimento'];

$sql = "UPDATE users SET nome = :nome, email = :email, cnpj = :cnpj, nome_emp = :nome_emp, cpf = :cpf, data_nascimento = :data_nascimento";
if ($senha) {
    $sql .= ", senha = :senha";
}
$sql .= " WHERE id = :id";

$stmt = $pdo->prepare($sql);

$params = [
    ':nome' => $nome,
    ':email' => $email,
    ':cnpj' => $cnpj,
    ':nome_emp' => $nome_emp,
    ':cpf' => $cpf,
    ':data_nascimento' => $data_nascimento,
    ':id' => $id
];

if ($senha) {
    $params[':senha'] = $senha;
}

$stmt->execute($params);

echo "Usuário atualizado com sucesso!";
?>