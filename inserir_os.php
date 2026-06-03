<?php
$host = 'localhost'; 
$dbname = 'loja_celular'; 
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Adaptado exatamente para as colunas da sua tabela
    $sql = "INSERT INTO vendas_os (cliente_id, tipo, produto_id, servico_id, quantidade, valor_total) 
            VALUES (:cliente_id, :tipo, :produto_id, :servico_id, :quantidade, :valor_total)";
    $stmt = $pdo->prepare($sql);
    
    // Tratamento para aceitar valores nulos caso o usuário não escolha produto ou serviço
    $produto = !empty($_POST['produto_id']) ? $_POST['produto_id'] : null;
    $servico = !empty($_POST['servico_id']) ? $_POST['servico_id'] : null;

    $stmt->execute([
        ':cliente_id' => $_POST['cliente_id'],
        ':tipo' => $_POST['tipo'],
        ':produto_id' => $produto,
        ':servico_id' => $servico,
        ':quantidade' => $_POST['quantidade'],
        ':valor_total' => $_POST['valor_total']
    ]);

    // Após salvar, salta para a lista de OS
    header("Location: listar_os.php");
    exit;

} catch (PDOException $e) {
    echo "<script>alert('Erro no banco de dados: " . $e->getMessage() . "'); window.history.back();</script>";
}
?>