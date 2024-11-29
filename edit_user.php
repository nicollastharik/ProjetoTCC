<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuário</title>
</head>
<body>
    <form action="update_user.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
        Senha: <input type="password" name="senha"><br>
        CNPJ: <input type="text" name="cnpj" value="<?php echo htmlspecialchars($user['cnpj']); ?>"><br>
        Nome da Empresa: <input type="text" name="nome_emp" value="<?php echo htmlspecialchars($user['nome_emp']); ?>"><br>
        CPF: <input type="text" name="cpf" value="<?php echo htmlspecialchars($user['cpf']); ?>"><br>
        Data de Nascimento: <input type="date" name="data_nascimento" value="<?php echo htmlspecialchars($user['data_nascimento']); ?>"><br>
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>