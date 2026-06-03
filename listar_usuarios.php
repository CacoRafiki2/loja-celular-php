<?php
session_start();
// Barreira de Segurança: Só admin entra aqui!
if (($_SESSION['perfil'] ?? 'comum') !== 'admin') {
    die("<h3 style='color:red; text-align:center; font-family:sans-serif; margin-top:50px;'>⛔ Acesso Negado! Apenas administradores podem acessar esta página.</h3>");
}

$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $usuarios = $pdo->query("SELECT id, nome, login, perfil FROM usuarios ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Usuários</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 30px; background-color: #f4f6f9; }
        h2 { color: #2c3e50; }
        .btn-novo { display: inline-block; padding: 10px 15px; background-color: #34495e; color: white; text-decoration: none; border-radius: 4px; margin-bottom: 20px; font-weight: bold; }
        .btn-novo:hover { background-color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; background-color: white; border-radius: 5px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ecf0f1; font-size: 14px; }
        th { background-color: #34495e; color: white; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; color: white; }
        .badge-admin { background-color: #e74c3c; }
        .badge-comum { background-color: #3498db; }
    </style>
</head>
<body>
    <h2>⚙️ Gestão de Usuários</h2>
    <a href="cadastro_usuario.php" class="btn-novo">+ Novo Usuário</a>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Completo</th>
                <th>Login de Acesso</th>
                <th>Perfil de Acesso</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><b><?= htmlspecialchars($u['nome']) ?></b></td>
                <td><?= htmlspecialchars($u['login']) ?></td>
                <td>
                    <?php if($u['perfil'] == 'admin'): ?>
                        <span class="badge badge-admin">Administrador</span>
                    <?php else: ?>
                        <span class="badge badge-comum">Comum</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>