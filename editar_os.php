<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Busca o registro atual
    $stmt = $pdo->prepare("SELECT * FROM vendas_os WHERE id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $os = $stmt->fetch(PDO::FETCH_ASSOC);

    // Busca as listas
    $clientes = $pdo->query("SELECT id, nome FROM clientes ORDER BY nome ASC")->fetchAll();
    $produtos = $pdo->query("SELECT id, nome FROM produtos ORDER BY nome ASC")->fetchAll();
    $servicos = $pdo->query("SELECT id, descricao FROM servicos ORDER BY descricao ASC")->fetchAll();
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Registro</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f4f6f9; }
        form { max-width: 500px; padding: 25px; background-color: white; border: 1px solid #ecf0f1; border-radius: 5px; }
        label { font-weight: bold; display: block; margin-top: 15px; font-size: 14px; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;}
        button { margin-top: 20px; padding: 12px; background-color: #f39c12; color: white; border: none; font-weight: bold; width: 100%; border-radius: 4px; cursor: pointer;}
    </style>
</head>
<body>
    <h2>✏️ Editar Registro #<?= $os['id'] ?></h2>
    <form action="atualizar_os.php" method="POST">
        <input type="hidden" name="id" value="<?= $os['id'] ?>">

        <label>Cliente:</label>
        <select name="cliente_id" required>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] == $os['cliente_id'] ? 'selected' : '' ?>><?= $c['nome'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Tipo (Venda ou OS):</label>
        <select name="tipo" required>
            <option value="Venda" <?= strtolower($os['tipo']) == 'venda' ? 'selected' : '' ?>>Venda de Produto</option>
            <option value="OS" <?= strtolower($os['tipo']) == 'os' ? 'selected' : '' ?>>Ordem de Serviço</option>
        </select>

        <label>Produto (Se for Venda):</label>
        <select name="produto_id">
            <option value="">-- Nenhum --</option>
            <?php foreach ($produtos as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $p['id'] == $os['produto_id'] ? 'selected' : '' ?>><?= $p['nome'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Serviço (Se for OS):</label>
        <select name="servico_id">
            <option value="">-- Nenhum --</option>
            <?php foreach ($servicos as $s): ?>
                <option value="<?= $s['id'] ?>" <?= $s['id'] == $os['servico_id'] ? 'selected' : '' ?>><?= $s['descricao'] ?></option>
            <?php endforeach; ?>
        </select>

        <label>Valor Total (R$):</label>
        <input type="number" name="valor_total" step="0.01" value="<?= $os['valor_total'] ?>" required>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>