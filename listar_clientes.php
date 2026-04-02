<?php
$host = 'localhost';
$dbname = 'loja_celular';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM clientes ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 30px; background-color: #f4f6f9; }
        h2 { color: #2c3e50; }
        .btn-novo { display: inline-block; padding: 10px 15px; background-color: #3498db; color: white; text-decoration: none; border-radius: 4px; margin-bottom: 20px; font-weight: bold; transition: 0.3s; }
        .btn-novo:hover { background-color: #2980b9; }
        table { width: 100%; border-collapse: collapse; background-color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 5px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ecf0f1; }
        th { background-color: #2c3e50; color: white; font-weight: 500; }
        tr:hover { background-color: #f8f9fa; }
        
        /* Estilos dos novos botões de ação */
        .btn-editar { background-color: #f1c40f; color: #333; padding: 6px 10px; text-decoration: none; border-radius: 3px; font-size: 13px; margin-right: 5px; font-weight: bold;}
        .btn-editar:hover { background-color: #f39c12; }
        .btn-excluir { background-color: #e74c3c; color: white; padding: 6px 10px; text-decoration: none; border-radius: 3px; font-size: 13px; }
        .btn-excluir:hover { background-color: #c0392b; }
    </style>
</head>
<body>

    <h2>👥 Lista de Clientes</h2>
    <a href="cadastro_cliente.html" class="btn-novo">+ Cadastrar Novo Cliente</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Ações</th> </tr>
        </thead>
        <tbody>
            <?php if (count($clientes) > 0): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= $cliente['id'] ?></td>
                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                        <td><?= htmlspecialchars($cliente['cpf']) ?></td>
                        <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                        <td><?= htmlspecialchars($cliente['endereco']) ?></td>
                        <td>
                            <a href="editar_cliente.php?id=<?= $cliente['id'] ?>" class="btn-editar">Editar</a>
                            <a href="excluir_cliente.php?id=<?= $cliente['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir o cliente <?= htmlspecialchars($cliente['nome']) ?>?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Nenhum cliente cadastrado ainda.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>