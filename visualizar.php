<?php
require_once 'db_connect.php';

$sql = "SELECT * FROM postar ORDER BY data_postagem DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Serviços</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-bottom: 20px;
        }
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
                <a class="nav-link active" href="visualizar.php">Visualizar</a>
                <a class="nav-link" href="servicos.html">Voltar</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Serviços Disponíveis</h2>
        
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card h-100">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row["titulo"]) . '</h5>';
                    echo '<h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($row["area"]) . '</h6>';
                    echo '<p class="card-text">' . htmlspecialchars($row["descricao"]) . '</p>';
                    echo '<p class="card-text"><strong>Preço:</strong> R$ ' . number_format($row["preco"], 2, ',', '.') . '</p>';
                    echo '<p class="card-text"><strong>Contato:</strong> ' . htmlspecialchars($row["contato"]) . '</p>';
                    echo '<p class="card-text"><strong>Nome:</strong> ' . htmlspecialchars($row["nome"]) . '</p>';
                    echo '<p class="card-text"><small class="text-muted">Postado em: ' . date('d/m/Y H:i', strtotime($row["data_postagem"])) . '</small></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12">';
                echo '<div class="alert alert-info" role="alert">';
                echo 'Nenhum serviço disponível no momento.';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>