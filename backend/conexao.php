<?php
// backend/conexao.php
$host = "localhost";
$usuario = "root"; // Padrão do XAMPP
$senha = "";       // Padrão do XAMPP (vazio)
$banco = "loja_celular";

// Criando a conexão
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
?>