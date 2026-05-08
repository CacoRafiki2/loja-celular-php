<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE servicos SET descricao = :descricao, preco_base = :preco_base WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':id' => $_POST['id'],
        ':descricao' => $_POST['descricao'],
        ':preco_base' => $_POST['preco_base']
    ]);

    header("Location: listar_servicos.php");
    exit;
} catch (PDOException $e) {
    echo "<script>alert('Erro ao atualizar: " . $e->getMessage() . "'); window.history.back();</script>";
}
?>