<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Agora usamos UPDATE ao invés de INSERT
    $sql = "UPDATE produtos SET nome = :nome, marca = :marca, preco = :preco, estoque = :estoque WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':id' => $_POST['id'],
        ':nome' => $_POST['nome'],
        ':marca' => $_POST['marca'],
        ':preco' => $_POST['preco'],
        ':estoque' => $_POST['estoque']
    ]);

    header("Location: listar_produtos.php");
    exit;
} catch (PDOException $e) {
    echo "<script>alert('Erro ao atualizar: " . $e->getMessage() . "'); window.history.back();</script>";
}
?>