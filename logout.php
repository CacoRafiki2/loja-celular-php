<?php
session_start();
session_destroy(); // derruba a sessão atual
header("Location: login.php"); // manda de volta pra tela de login
exit;
?>