<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pega o ID que veio no link do botão
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) { die("Produto não encontrado!"); }
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f4f6f9; }
        .cabecalho { display: flex; justify-content: space-between; align-items: center; max-width: 400px; margin-bottom: 20px; }
        h2 { color: #2c3e50; margin: 0; }
        .btn-voltar { background-color: #7f8c8d; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 14px; }
        .btn-voltar:hover { background-color: #95a5a6; }
        form { max-width: 400px; padding: 25px; background-color: white; border: 1px solid #ecf0f1; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .linha-dupla { display: flex; gap: 15px; } .coluna { flex: 1; }
        label { font-weight: bold; display: block; margin-top: 15px; color: #34495e; font-size: 14px; }
        input { width: 100%; padding: 10px; margin-top: 5px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { margin-top: 20px; padding: 12px 15px; background-color: #3498db; color: white; border: none; cursor: pointer; border-radius: 4px; font-weight: bold; width: 100%; transition: 0.3s; }
        button:hover { background-color: #2980b9; }
    </style>
</head>
<body>
    <div class="cabecalho">
        <h2>✏️ Editar Produto</h2>
        <a href="listar_produtos.php" class="btn-voltar">⬅️ Voltar</a>
    </div>
    
    <form action="atualizar_produto.php" method="POST">
        <input type="hidden" name="id" value="<?= $produto['id'] ?>">

        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>

        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" value="<?= htmlspecialchars($produto['marca']) ?>" required>

        <div class="linha-dupla">
            <div class="coluna">
                <label for="preco">Preço Unitário (R$):</label>
                <input type="number" id="preco" name="preco" step="0.01" value="<?= $produto['preco'] ?>" required>
            </div>
            <div class="coluna">
                <label for="estoque">Estoque (Qtd):</label>
                <input type="number" id="estoque" name="estoque" value="<?= $produto['estoque'] ?>" required>
            </div>
        </div>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>