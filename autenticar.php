<?php
session_start();

$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    $sql = "SELECT * FROM usuarios WHERE login = :login AND senha = :senha";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':login' => $_POST['login'], ':senha' => $_POST['senha']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Grava o nome e o PERFIL no crachá do usuário!
        $_SESSION['usuario_logado'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['perfil']; 
        
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Usuário ou senha incorretos!'); window.location.href='login.php';</script>";
    }
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }
?>