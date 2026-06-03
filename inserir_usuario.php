<?php
session_start();
if (($_SESSION['perfil'] ?? 'comum') !== 'admin') {
    die("Acesso Negado!");
}

$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Insere o novo usuário no banco
    $sql = "INSERT INTO usuarios (nome, login, senha, perfil) VALUES (:nome, :login, :senha, :perfil)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':nome' => $_POST['nome'],
        ':login' => $_POST['login'],
        ':senha' => $_POST['senha'],
        ':perfil' => $_POST['perfil']
    ]);

    // Salta de volta para a lista de usuários
    header("Location: listar_usuarios.php");
    exit;

} catch (PDOException $e) {
    echo "<script>alert('Erro ao salvar. Verifique se o login já existe!'); window.history.back();</script>";
}
?>