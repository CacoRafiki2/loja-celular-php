<?php
$host = 'localhost';
$dbname = 'loja_celular'; 
$username = 'root';
$password = '';

try {
    // 1. Conecta ao banco
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Prepara e salva os dados
    $sql = "INSERT INTO produtos (nome, marca, preco, estoque) VALUES (:nome, :marca, :preco, :estoque)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':nome' => $_POST['nome'],
        ':marca' => $_POST['marca'],
        ':preco' => $_POST['preco'],
        ':estoque' => $_POST['estoque']
    ]);

    // 3. Redireciona instantaneamente para a tela de estoque
    header("Location: listar_produtos.php");
    exit; // O exit garante que o script pare de rodar após o redirecionamento

} catch (PDOException $e) {
    // Se der erro no banco, volta para a tela anterior e avisa
    echo "<script>
            alert('Erro ao cadastrar produto: " . $e->getMessage() . "');
            window.history.back();
          </script>";
}
?>