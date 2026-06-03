<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
if(isset($_GET['id'])){
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->query("UPDATE vendas_os SET status = 'Finalizado' WHERE id = " . intval($_GET['id']));
}
// Pega a página anterior para voltar para a mesma aba que o usuário estava
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>