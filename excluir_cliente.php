<?php
$host = 'localhost';
$dbname = 'loja_celular';
$username = 'root';
$password = '';

if (isset($_GET['id'])) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Pega o ID que veio escondido no botão vermelho
        $id = $_GET['id'];
        
        // Manda o banco de dados deletar
        $sql = "DELETE FROM clientes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        // Volta para a tela de clientes
        header("Location: listar_clientes.php");
        exit;

    } catch (PDOException $e) {
        die("Erro ao excluir: " . $e->getMessage());
    }
} else {
    header("Location: listar_clientes.php");
}
?>