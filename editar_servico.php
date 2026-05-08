<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM servicos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $servico = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$servico) { die("Serviço não encontrado!"); }
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Serviço</title>
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
        <h2>✏️ Editar Serviço</h2>
        <a href="listar_servicos.php" class="btn-voltar">⬅️ Voltar</a>
    </div>
    
    <form action="atualizar_servico.php" method="POST">
        <input type="hidden" name="id" value="<?= $servico['id'] ?>">

        <label for="descricao">Descrição do Serviço:</label>
        <input type="text" id="descricao" name="descricao" value="<?= htmlspecialchars($servico['descricao']) ?>" required>

        <label for="preco_base">Preço Base (R$):</label>
        <input type="number" id="preco_base" name="preco_base" step="0.01" value="<?= $servico['preco_base'] ?>" required>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>