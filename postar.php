<?php
require_once 'db_connect.php';

// Verificar se a conexão foi bem-sucedida
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $preco = filter_var($_POST['preco'], FILTER_VALIDATE_FLOAT);
    $contato = mysqli_real_escape_string($conn, $_POST['contato']);
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);

    // Verificar o tamanho da string 'area' antes de inserir
    $max_area_length = 50; // Ajuste este valor de acordo com o tamanho definido no seu banco de dados
    if (strlen($area) > $max_area_length) {
        $area = substr($area, 0, $max_area_length);
    }

    // Verificar se o preço é válido
    if ($preco === false || $preco < 0 || $preco > 9999999.99) { // Ajuste o valor máximo conforme necessário
        $mensagem = '<div class="alert alert-danger">Erro: O preço inserido é inválido. Por favor, insira um valor entre 0 e 9.999.999,99.</div>';
    } else {
        $sql = "INSERT INTO postar (titulo, descricao, area, preco, contato, nome)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssdss", $titulo, $descricao, $area, $preco, $contato, $nome);

        if (mysqli_stmt_execute($stmt)) {
            $mensagem = '<div class="alert alert-success">Serviço publicado com sucesso!</div>';
        } else {
            $mensagem = '<div class="alert alert-danger">Erro ao publicar serviço: ' . mysqli_error($conn) . '</div>';
        }

        mysqli_stmt_close($stmt);
    }
}

// ... (o resto do código HTML permanece o mesmo)
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postar Serviço</title>
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
    <nav class="navbar navbar-expand-lg navbar-dark mb-4" style="background-color: #ff5f11;">
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
        <h2>Publicar Novo Serviço</h2>
        <?php echo $mensagem; ?>
        <div class="card">
            <div class="card-body">
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
                    <button type="submit" class="btn btn-custom">Publicar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>