<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) { die("Cliente não encontrado!"); }
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f4f6f9; }
        .cabecalho { display: flex; justify-content: space-between; align-items: center; max-width: 450px; margin-bottom: 20px; }
        h2 { color: #2c3e50; margin: 0; }
        .btn-voltar { background-color: #7f8c8d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 14px; }
        .btn-voltar:hover { background-color: #95a5a6; }
        form { max-width: 450px; padding: 25px; background-color: white; border: 1px solid #ecf0f1; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        label { font-weight: bold; display: block; margin-top: 15px; color: #34495e; font-size: 14px; }
        input { width: 100%; padding: 10px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 20px; padding: 12px 15px; background-color: #f1c40f; color: #333; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; width: 100%; transition: 0.3s; }
        button:hover { background-color: #f39c12; }
    </style>
</head>
<body>
    <div class="cabecalho">
        <h2>✏️ Editar Cliente</h2>
        <a href="listar_clientes.php" class="btn-voltar">⬅️ Voltar</a>
    </div>
    
    <form action="atualizar_cliente.php" method="POST">
        <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

        <label for="nome">Nome Completo:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($cliente['cpf']) ?>" required>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>" required>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco']) ?>" required>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>