<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE clientes SET nome = :nome, cpf = :cpf, telefone = :telefone, endereco = :endereco WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':id' => $_POST['id'],
        ':nome' => $_POST['nome'],
        ':cpf' => $_POST['cpf'],
        ':telefone' => $_POST['telefone'],
        ':endereco' => $_POST['endereco']
    ]);

    header("Location: listar_clientes.php");
    exit;
} catch (PDOException $e) {
    echo "<script>alert('Erro ao atualizar: " . $e->getMessage() . "'); window.history.back();</script>";
}
?>