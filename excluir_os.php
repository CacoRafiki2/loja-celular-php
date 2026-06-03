<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
if(isset($_GET['id'])){
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->query("DELETE FROM vendas_os WHERE id = " . intval($_GET['id']));
}
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>