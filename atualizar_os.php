<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    $sql = "UPDATE vendas_os SET cliente_id = :cliente, tipo = :tipo, produto_id = :produto, servico_id = :servico, valor_total = :valor WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':id' => $_POST['id'],
        ':cliente' => $_POST['cliente_id'],
        ':tipo' => $_POST['tipo'],
        ':produto' => !empty($_POST['produto_id']) ? $_POST['produto_id'] : null,
        ':servico' => !empty($_POST['servico_id']) ? $_POST['servico_id'] : null,
        ':valor' => $_POST['valor_total']
    ]);

    header("Location: listar_os.php");
    exit;
} catch (PDOException $e) { echo "Erro: " . $e->getMessage(); }
?>