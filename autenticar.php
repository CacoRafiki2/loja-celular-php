<?php
session_start(); // Inicia a sessão (entrega o crachá)

$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Pega o que foi digitado na tela de login
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Procura no banco de dados
    $sql = "SELECT * FROM usuarios WHERE login = :login AND senha = :senha";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':login' => $login, ':senha' => $senha]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Se achou, cria o crachá virtual com o nome dele e libera a catraca!
        $_SESSION['usuario_logado'] = $usuario['nome'];
        header("Location: index.php");
        exit;
    } else {
        // Se errou, manda de volta com um aviso
        echo "<script>alert('Usuário ou senha incorretos!'); window.location.href='login.php';</script>";
    }

} catch (PDOException $e) {
    die("Erro no banco de dados: " . $e->getMessage());
}
?>