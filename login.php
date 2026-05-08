<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Loja Celular</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #2c3e50; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); width: 100%; max-width: 350px; text-align: center; }
        .login-box h2 { margin-top: 0; color: #2c3e50; margin-bottom: 25px; }
        .login-box img { width: 60px; margin-bottom: 15px; }
        label { display: block; text-align: left; margin-bottom: 5px; font-weight: bold; color: #34495e; font-size: 14px; }
        input { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #bdc3c7; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #3498db; color: white; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        button:hover { background-color: #2980b9; }
    </style>
</head>
<body>

    <div class="login-box">
        <h2>📱 Loja Celular</h2>
        <form action="autenticar.php" method="POST">
            <label for="login">Usuário:</label>
            <input type="text" id="login" name="login" placeholder="Digite seu usuário" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

            <button type="submit">Entrar no Sistema</button>
        </form>
    </div>

</body>
</html>