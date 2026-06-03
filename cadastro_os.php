<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Buscando as 3 listas no banco de dados para preencher as caixinhas!
    $clientes = $pdo->query("SELECT id, nome FROM clientes ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);
    $produtos = $pdo->query("SELECT id, nome FROM produtos ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);
    $servicos = $pdo->query("SELECT id, descricao FROM servicos ORDER BY descricao ASC")->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nova Venda / OS</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f4f6f9; }
        .cabecalho { display: flex; justify-content: space-between; align-items: center; max-width: 500px; margin-bottom: 20px; }
        h2 { color: #2c3e50; margin: 0; }
        .btn-listar { background-color: #7f8c8d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 14px; }
        .btn-listar:hover { background-color: #95a5a6; }
        form { max-width: 500px; padding: 25px; background-color: white; border: 1px solid #ecf0f1; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        label { font-weight: bold; display: block; margin-top: 15px; color: #34495e; font-size: 14px; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 20px; padding: 12px 15px; background-color: #8e44ad; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; width: 100%; transition: 0.3s; }
        button:hover { background-color: #732d91; }
        .linha-dupla { display: flex; gap: 15px; } .coluna { flex: 1; }
    </style>
</head>
<body>

    <div class="cabecalho">
        <h2>🧾 Nova Venda ou OS</h2>
        <a href="listar_os.php" class="btn-listar">📋 Listar Registros</a>
    </div>
    
    <form action="inserir_os.php" method="POST">
        
        <label for="cliente_id">Selecione o Cliente:</label>
        <select id="cliente_id" name="cliente_id" required>
            <option value="">-- Escolha um cliente --</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <div class="linha-dupla">
            <div class="coluna">
                <label for="tipo">Tipo de Operação:</label>
                <select id="tipo" name="tipo" required>
                    <option value="Venda">Venda de Produto</option>
                    <option value="OS">Ordem de Serviço</option>
                </select>
            </div>
            <div class="coluna">
                <label for="quantidade">Quantidade:</label>
                <input type="number" id="quantidade" name="quantidade" value="1" required>
            </div>
        </div>

        <label for="produto_id">Produto (Se for Venda):</label>
        <select id="produto_id" name="produto_id">
            <option value="">-- Nenhum Produto --</option>
            <?php foreach ($produtos as $produto): ?>
                <option value="<?= $produto['id'] ?>"><?= htmlspecialchars($produto['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="servico_id">Serviço (Se for OS):</label>
        <select id="servico_id" name="servico_id">
            <option value="">-- Nenhum Serviço --</option>
            <?php foreach ($servicos as $servico): ?>
                <option value="<?= $servico['id'] ?>"><?= htmlspecialchars($servico['descricao']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="valor_total">Valor Total (R$):</label>
        <input type="number" id="valor_total" name="valor_total" step="0.01" required>

        <button type="submit">Gravar Registro</button>
    </form>

</body>
</html>