
?>

<?php
$dbhost = "localhost:3307"; // Nome do host do banco de dados
$dbname = "db_sessao";      // Nome do banco de dados
$dbusuario = "root";        // Usuário do banco de dados
$dbsenha = "senac";         // Senha do banco de dados

// Conexão com o banco de dados
$criarConexao = mysqli_connect($dbhost, $dbusuario, $dbsenha, $dbname);

// Verifica a conexão
if (!$criarConexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>
