<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

// Criar conexão
$conn = new mysqli($servername, $username, $password);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Criar banco de dados
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados criado com sucesso ou já existente<br>";
} else {
    echo "Erro ao criar banco de dados: " . $conn->error;
}

$conn->select_db($dbname);

// Criar tabela
$sql = "CREATE TABLE IF NOT EXISTS postar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao VARCHAR(500) NOT NULL,
    area ENUM('Tecnologia', 'Industria', 'Seviços Gerais', 'Fitness e saúde', 'Varejo', 'Limpeza', 'Outros') NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    contato VARCHAR(100) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Tabela criada com sucesso ou já existente<br>";
} else {
    echo "Erro ao criar tabela: " . $conn->error;
}

// Processar formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $area = $conn->real_escape_string($_POST['area']);
    $preco = $conn->real_escape_string($_POST['preco']);
    $contato = $conn->real_escape_string($_POST['contato']);
    $nome = $conn->real_escape_string($_POST['nome']);

    $sql = "INSERT INTO postar (titulo, descricao, area, preco, contato, nome)
            VALUES ('$titulo', '$descricao', '$area', '$preco', '$contato', '$nome')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Serviço publicado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao publicar serviço: " . $conn->error . "</div>";
    }
}

// Buscar todos os serviços
$sql = "SELECT * FROM postar ORDER BY data_postagem DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divulgação de Serviços</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f2ef;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .navbar {
            background-color: #0a66c2;
        }
        .navbar-brand {
            color: white !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">ServiçosNet</a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Publicar novo serviço</h5>
                        <form method="post">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="area" class="form-label">Área</label>
                                <select class="form-control" id="area" name="area" required>
                                    <option value="Tecnologia">Tecnologia</option>
                                    <option value="Industria">Indústria</option>
                                    <option value="Seviços Gerais">Serviços Gerais</option>
                                    <option value="Fitness e saúde">Fitness e saúde</option>
                                    <option value="Varejo">Varejo</option>
                                    <option value="Limpeza">Limpeza</option>
                                    <option value="Outros">Outros</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="preco" class="form-label">Preço</label>
                                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                            </div>
                            <div class="mb-3">
                                <label for="contato" class="form-label">Contato</label>
                                <input type="text" class="form-control" id="contato" name="contato" required>
                            </div>
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Publicar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h3>Serviços Disponíveis</h3>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($row["titulo"]) . '</h5>';
                        echo '<h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($row["area"]) . ' - R$ ' . number_format($row["preco"], 2, ',', '.') . '</h6>';
                        echo '<p class="card-text">' . htmlspecialchars($row["descricao"]) . '</p>';
                        echo '<p class="card-text"><small class="text-muted">Oferecido por: ' . htmlspecialchars($row["nome"]) . '</small></p>';
                        echo '<p class="card-text"><small class="text-muted">Contato: ' . htmlspecialchars($row["contato"]) . '</small></p>';
                        echo '<p class="card-text"><small class="text-muted">Publicado em: ' . $row["data_postagem"] . '</small></p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>Nenhum serviço encontrado.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>