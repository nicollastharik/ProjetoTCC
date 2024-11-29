<?php
require_once 'db_connect.php';

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $sql = "DELETE FROM postar WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            $mensagem = '<div class="alert alert-success">Serviço excluído com sucesso!</div>';
        } else {
            $mensagem = '<div class="alert alert-danger">Erro ao excluir serviço: ' . $conn->error . '</div>';
        }
    } elseif (isset($_POST['update'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $titulo = $conn->real_escape_string($_POST['titulo']);
        $descricao = $conn->real_escape_string($_POST['descricao']);
        $area = $conn->real_escape_string($_POST['area']);
        $preco = $conn->real_escape_string($_POST['preco']);
        $contato = $conn->real_escape_string($_POST['contato']);
        $nome = $conn->real_escape_string($_POST['nome']);

        $sql = "UPDATE postar SET 
                titulo = '$titulo',
                descricao = '$descricao',
                area = '$area',
                preco = '$preco',
                contato = '$contato',
                nome = '$nome'
                WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $mensagem = '<div class="alert alert-success">Serviço atualizado com sucesso!</div>';
        } else {
            $mensagem = '<div class="alert alert-danger">Erro ao atualizar serviço: ' . $conn->error . '</div>';
        }
    }
}

$sql = "SELECT * FROM postar ORDER BY data_postagem DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Serviços</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #ff5f11 !important;
        }
        .btn-custom {
            background-color: #ff5f11 !important;
            color: white !important;
        }
        .btn-custom:hover {
            background-color: #e54e00 !important;
            color: white !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Outsourced</a>
            <div class="navbar-nav">
                <a class="nav-link" href="postar.php">Postar</a>
                <a class="nav-link" href="gerenciar.php">Gerenciar</a>
                <a class="nav-link" href="visualizar.php">Visualizar</a>
                <a class="nav-link" href="servicos.html">Voltar</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Gerenciar Serviços</h2>
        <?php echo $mensagem; ?>
        
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="card mb-4">';
                echo '<div class="card-body">';
                echo '<form method="post">';
                echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
                
                echo '<div class="mb-3">';
                echo '<label for="titulo" class="form-label">Título</label>';
                echo '<input type="text" class="form-control" name="titulo" value="' . htmlspecialchars($row["titulo"]) . '" required>';
                echo '</div>';
                
                echo '<div class="mb-3">';
                echo '<label for="descricao" class="form-label">Descrição</label>';
                echo '<textarea class="form-control" name="descricao" rows="3" required>' . htmlspecialchars($row["descricao"]) . '</textarea>';
                echo '</div>';
                
                echo '<div class="mb-3">';
                echo '<label for="area" class="form-label">Área</label>';
                echo '<select class="form-control" name="area" required>';
                $areas = ['Tecnologia', 'Industria', 'Seviços Gerais', 'Fitness e saúde', 'Varejo', 'Limpeza', 'Outros'];
                foreach ($areas as $area) {
                    $selected = ($area == $row["area"]) ? 'selected' : '';
                    echo "<option value='$area' $selected>$area</option>";
                }
                echo '</select>';
                echo '</div>';
                
                echo '<div class="mb-3">';
                echo '<label for="preco" class="form-label">Preço</label>';
                echo '<input type="number" step="0.01" class="form-control" name="preco" value="' . $row["preco"] . '" required>';
                echo '</div>';
                
                echo '<div class="mb-3">';
                echo '<label for="contato" class="form-label">Contato</label>';
                echo '<input type="text" class="form-control" name="contato" value="' . htmlspecialchars($row["contato"]) . '" required>';
                echo '</div>';
                
                echo '<div class="mb-3">';
                echo '<label for="nome" class="form-label">Nome</label>';
                echo '<input type="text" class="form-control" name="nome" value="' . htmlspecialchars($row["nome"]) . '" required>';
                echo '</div>';
                
                echo '<button type="submit" name="update" class="btn btn-primary me-2">Atualizar</button>';
                echo '<button type="submit" name="delete" class="btn btn-danger" onclick="return confirm(\'Tem certeza que deseja excluir este serviço?\')">Excluir</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p>Nenhum serviço encontrado.</p>";
        }
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>