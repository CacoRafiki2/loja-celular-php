<?php
session_start();
if (($_SESSION['perfil'] ?? 'comum') !== 'admin') {
    die("Acesso Negado!");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Usuário</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f4f6f9; }
        form { max-width: 400px; padding: 25px; background-color: white; border: 1px solid #ecf0f1; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        label { font-weight: bold; display: block; margin-top: 15px; font-size: 14px; }
        input, select { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 12px; background-color: #34495e; color: white; border: none; font-weight: bold; width: 100%; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>👤 Cadastrar Novo Usuário</h2>
    <form action="inserir_usuario.php" method="POST">
        <label>Nome Completo:</label>
        <input type="text" name="nome" required placeholder="Ex: João Silva">

        <label>Login de Acesso:</label>
        <input type="text" name="login" required placeholder="Ex: joao.silva">

        <label>Senha:</label>
        <input type="password" name="senha" required placeholder="Digite a senha">

        <label>Perfil de Acesso:</label>
        <select name="perfil" required>
            <option value="comum">Comum (Apenas cadastros e vendas)</option>
            <option value="admin">Administrador (Acesso total)</option>
        </select>

        <button type="submit">Salvar Usuário</button>
    </form>
</body>
</html>