<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <form action="cadastro.php" method="POST">
            <div class="formulario">
                <h1>Faça seu cadastro</h1>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu nome">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
                <input class="botao" type="submit" value="Enviar">
            </div>
        </form>
    </div>

    <?php
    // Inclui o arquivo de configuração do banco de dados
    include('bankconfig.php');

    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $senha = $_POST['senha'];

        // Criptografa a senha antes de inserir no banco de dados
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Prepara e executa a consulta SQL de inserção
        $sql = "INSERT INTO td_usuarios (nome, senha) VALUES ('$nome', '$senha_hash')";
        if (mysqli_query($criarConexao, $sql)) {
            echo "Usuário cadastrado com sucesso!";
            header('Location: login.php'); // Redireciona para a página de login
            exit;
        } else {
            echo "Erro ao cadastrar o usuário: " . mysqli_error($criarConexao);
        }

        // Fecha a conexão com o banco de dados
        mysqli_close($criarConexao);
    }
    ?>
</body>

</html>
