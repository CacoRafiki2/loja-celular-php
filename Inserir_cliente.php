<?php
$host = 'localhost';
$dbname = 'loja_celular'; 
$username = 'root';
$password = '';

try {
    // Conecta ao banco
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepara e salva os dados do CLIENTE
    $sql = "INSERT INTO clientes (nome, cpf, telefone, endereco) VALUES (:nome, :cpf, :telefone, :endereco)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':nome' => $_POST['nome'],
        ':cpf' => $_POST['cpf'],
        ':telefone' => $_POST['telefone'],
        ':endereco' => $_POST['endereco']
    ]);

    // Redireciona instantaneamente para a tela de lista de clientes
    header("Location: listar_clientes.php");
    exit;

} catch (PDOException $e) {
    // Se der erro, volta e avisa
    echo "<script>
            alert('Erro ao cadastrar cliente: " . $e->getMessage() . "');
            window.history.back();
          </script>";
}
?>