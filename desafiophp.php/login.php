<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <form action="login.php" method="POST">
            <div class="formulario">
                <h1>Faça seu Login</h1>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu nome">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
                <input class="botao" name="submit" type="submit" value="Logar">
            </div>
        </form>
    </div>

    <?php
    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include('bankconfig.php');

        // Verifica se os campos foram preenchidos
        if (!empty($_POST['nome']) && !empty($_POST['senha'])) {
            $nome = $_POST['nome'];
            $senha_digitada = $_POST['senha'];

            // Consulta SQL usando prepared statement para evitar SQL Injection
            $sql = "SELECT * FROM td_usuarios WHERE nome = ?";
            $stmt = mysqli_prepare($criarConexao, $sql);

            // Verifica se a preparação da consulta foi bem-sucedida
            if ($stmt) {
                // Bind parameters
                mysqli_stmt_bind_param($stmt, "s", $nome);

                // Executa a consulta
                mysqli_stmt_execute($stmt);

                // Obtém o resultado da consulta
                $resultado = mysqli_stmt_get_result($stmt);

                // Verifica se encontrou algum usuário
                if (mysqli_num_rows($resultado) > 0) {
                    $usuario = mysqli_fetch_assoc($resultado);

                    // Verifica se a senha digitada corresponde à senha armazenada usando password_verify
                    if (password_verify($senha_digitada, $usuario['senha'])) {
                        // Login e senha corretos, redireciona para página autorizada
                        session_start();
                        $_SESSION['usuario'] = $usuario['nome'];
                        header('Location: index.php');
                        exit; // Encerra o script para evitar redirecionamento indesejado
                    } else {
                        echo "<p class='erro'>Senha incorreta!</p>";
                    }
                } else {
                    echo "<p class='erro'>Usuário não encontrado!</p>";
                }

                // Fecha o statement
                mysqli_stmt_close($stmt);
            } else {
                echo "<p class='erro'>Erro na preparação da consulta: " . mysqli_error($criarConexao) . "</p>";
            }
        } else {
            echo "<p class='erro'>Por favor, preencha todos os campos!</p>";
        }

        // Fecha a conexão com o banco de dados
        mysqli_close($criarConexao);
    }
    ?>
</body>

</html>
