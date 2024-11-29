<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
   <div class = 'centro'><h1>Cadastre-se</h1></div> 

    <form action="register_process.php" method="POST">
        Nome: <input type="text" name="nome" required><br>
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        CNPJ: <input type="text" name="cnpj"><br>
        Nome da Empresa: <input type="text" name="nome_emp"><br>
        CPF: <input type="text" name="cpf"><br>
        Data de Nascimento: <input type="date" name="data_nascimento"><br>
        <input type="submit" value="Registrar">
        <a href="index.html"><input class='button' type="button" value="Voltar"></a>
        <a href="login.html"><input class='button' type="button" value="Login"></a>
    </form>
</body>
</html>