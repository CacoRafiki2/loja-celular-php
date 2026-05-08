<?php
$host = 'localhost'; 
$dbname = 'loja_celular'; 
$username = 'root'; 
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT * FROM servicos ORDER BY descricao ASC";
    $stmt = $pdo->query($sql);
    $servicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { 
    die("Erro: " . $e->getMessage()); 
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Serviços</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 30px; background-color: #f4f6f9; }
        h2 { color: #2c3e50; }
        .btn-novo { display: inline-block; padding: 10px 15px; background-color: #27ae60; color: white; text-decoration: none; border-radius: 4px; margin-bottom: 20px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; background-color: white; border-radius: 5px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ecf0f1; }
        th { background-color: #2c3e50; color: white; }
        
        /* Estilos dos botões de ação */
        .btn-editar { background-color: #f1c40f; color: #333; padding: 6px 10px; text-decoration: none; border-radius: 3px; font-size: 13px; margin-right: 5px; font-weight: bold;}
        .btn-editar:hover { background-color: #f39c12; }
        .btn-excluir { background-color: #e74c3c; color: white; padding: 6px 10px; text-decoration: none; border-radius: 3px; font-size: 13px; }
        .btn-excluir:hover { background-color: #c0392b; }
    </style>
</head>
<body>
    <h2>🛠️ Catálogo de Serviços</h2>
    <a href="cadastro_servico.html" class="btn-novo">+ Novo Serviço</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição do Serviço</th>
                <th>Preço Base</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($servicos) > 0): ?>
                <?php foreach ($servicos as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><b><?= htmlspecialchars($s['descricao']) ?></b></td>
                    <td>R$ <?= number_format($s['preco_base'], 2, ',', '.') ?></td>
                    <td>
                        <a href="editar_servico.php?id=<?= $s['id'] ?>" class="btn-editar">Editar</a>
                        <a href="excluir_servico.php?id=<?= $s['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este serviço?');">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center; padding: 20px;">Nenhum serviço cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>