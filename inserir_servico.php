<?php
$host = 'localhost'; 
$dbname = 'loja_celular'; 
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // O SQL agora usa os nomes EXATOS da sua tabela
    $sql = "INSERT INTO servicos (descricao, preco_base) VALUES (:descricao, :preco_base)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':descricao' => $_POST['descricao'],
        ':preco_base' => $_POST['preco_base']
    ]);

    header("Location: listar_servicos.php");
    exit;

} catch (PDOException $e) {
    echo "<script>alert('Erro: " . $e->getMessage() . "'); window.history.back();</script>";
}
?>