<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';

if (isset($_GET['id'])) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_GET['id'];
        
        $sql = "DELETE FROM servicos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        header("Location: listar_servicos.php");
        exit;

    } catch (PDOException $e) {
        die("Erro ao excluir: " . $e->getMessage());
    }
} else {
    header("Location: listar_servicos.php");
}
?>