<?php
$host = 'localhost';
$dbname = 'loja_celular';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM produtos ORDER BY nome ASC";
    $stmt = $pdo->query($sql);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Estoque de Produtos</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 30px; background-color: #f4f6f9; }
        h2 { color: #2c3e50; }
        .btn-novo { display: inline-block; padding: 10px 15px; background-color: #e67e22; color: white; text-decoration: none; border-radius: 4px; margin-bottom: 20px; font-weight: bold; }
        .btn-novo:hover { background-color: #d35400; }
        table { width: 100%; border-collapse: collapse; background-color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 5px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ecf0f1; }
        th { background-color: #2c3e50; color: white; font-weight: 500; }
        tr:hover { background-color: #f8f9fa; }
        .estoque-baixo { color: red; font-weight: bold; }
        
        /* Estilos dos novos botões de ação */
        .btn-editar { background-color: #3498db; color: white; padding: 6px 10px; text-decoration: none; border-radius: 3px; font-size: 13px; margin-right: 5px; }
        .btn-editar:hover { background-color: #2980b9; }
        .btn-excluir { background-color: #e74c3c; color: white; padding: 6px 10px; text-decoration: none; border-radius: 3px; font-size: 13px; }
        .btn-excluir:hover { background-color: #c0392b; }
    </style>
</head>
<body>

    <h2>📦 Estoque de Produtos</h2>
    <a href="cadastro_produto.html" class="btn-novo">+ Cadastrar Novo Produto</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Marca</th>
                <th>Preço (R$)</th>
                <th>Estoque</th>
                <th>Ações</th> </tr>
        </thead>
        <tbody>
            <?php if (count($produtos) > 0): ?>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?= $produto['id'] ?></td>
                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                        <td><?= htmlspecialchars($produto['marca']) ?></td>
                        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                        <td class="<?= $produto['estoque'] < 5 ? 'estoque-baixo' : '' ?>">
                            <?= $produto['estoque'] ?> un.
                        </td>
                        <td>
                            <a href="editar_produto.php?id=<?= $produto['id'] ?>" class="btn-editar">Editar</a>
                            <a href="excluir_produto.php?id=<?= $produto['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir o produto <?= htmlspecialchars($produto['nome']) ?>?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Estoque vazio. Nenhum produto cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>