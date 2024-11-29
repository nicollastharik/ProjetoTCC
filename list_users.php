<?php
include 'db.php';

$sql = "SELECT * FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuários</title>
</head>
<body>
    <h1>Usuários Registrados</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>CNPJ</th>
            <th>Nome da Empresa</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo htmlspecialchars($user['nome']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['senha']); ?></td>
            <td><?php echo htmlspecialchars($user['cnpj']); ?></td>
            <td><?php echo htmlspecialchars($user['nome_emp']); ?></td>
            <td><?php echo htmlspecialchars($user['cpf']); ?></td>
            <td><?php echo htmlspecialchars($user['data_nascimento']); ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Editar</a> | 
                <a href="delete_user.php?id=<?php echo $user['id']; ?>">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>