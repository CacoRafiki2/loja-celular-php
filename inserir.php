<?php
$host = 'localhost';
$dbname = 'loja_celular'; 
$username = 'root';
$password = '';

try {
    // 1. Criando a conexão
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Pegando os dados do formulário HTML
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    // 3. Preparando o comando SQL
    $sql = "INSERT INTO clientes (nome, cpf, telefone, endereco) VALUES (:nome, :cpf, :telefone, :endereco)";
    $stmt = $pdo->prepare($sql);

    // 4. Executando a inserção
    $stmt->execute([
        ':nome' => $nome,
        ':cpf' => $cpf,
        ':telefone' => $telefone,
        ':endereco' => $endereco
    ]);

    // 5. Mensagem de Sucesso (Alerta na tela)
    echo "<script>
            alert('Cliente $nome cadastrado com sucesso!');
            window.location.href = 'cadastro_cliente.html';
          </script>";

} catch (PDOException $e) {
    // 6. Mensagem de Erro (Alerta na tela)
    echo "<script>
            alert('Erro ao cadastrar: " . $e->getMessage() . "');
            window.location.href = 'cadastro_cliente.html';
          </script>";
}
?>