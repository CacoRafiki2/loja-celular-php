<?php
session_start();
if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel - Loja Celular</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; height: 100vh; overflow: hidden; background-color: #f4f6f9; }
        
        /* AQUI ESTÁ O SEGREDO: Adicionamos position: relative na .sidebar */
        .sidebar { 
            width: 260px; 
            background-color: #2c3e50; 
            color: white; 
            display: flex; 
            flex-direction: column; 
            box-shadow: 2px 0 5px rgba(0,0,0,0.1); 
            z-index: 10; 
            position: relative; 
        }
        
        /* Ajuste no título para alinhar a imagem com o texto */
        .sidebar h2 { display: flex; align-items: center; justify-content: center; padding: 25px 0; border-bottom: 1px solid #1a252f; margin: 0; font-size: 22px; background-color: #1a252f; }
        
        /* Tamanho da logo no título */
        .sidebar h2 img { width: 28px; height: 28px; margin-right: 10px; }

        .sidebar p { text-align: center; font-size: 12px; color: #95a5a6; margin-bottom: 10px; }
        
        /* Transformamos os links em 'flex' para alinhar a imagem e o texto perfeitamente lado a lado */
        .sidebar a { display: flex; align-items: center; padding: 18px 20px; color: #ecf0f1; text-decoration: none; border-bottom: 1px solid #34495e; transition: 0.3s; font-size: 15px; }
        .sidebar a:hover { background-color: #3498db; padding-left: 25px; }
        
        /* Configuração do tamanho dos ícones do menu */
        .sidebar a img { width: 20px; height: 20px; margin-right: 12px; }

        /* Estilo do Botão de Logout Fixo no Rodapé */
        .btn-logout {
            position: absolute;
            bottom: 20px;
            left: 20px;
            width: calc(100% - 40px); /* Ocupa a largura do menu com uma margem */
            background-color: #e74c3c;
            color: white;
            padding: 12px 15px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
            box-sizing: border-box;
            transition: background-color 0.3s;
            /* Tirando os estilos padrão dos outros links da sidebar para o botão não desconfigurar */
            border-bottom: none !important;
            justify-content: center;
        }

        .btn-logout:hover {
            background-color: #c0392b !important;
            padding-left: 15px !important; /* Evita que o botão "ande" pra direita ao passar o mouse */
        }

        .content { flex: 1; display: flex; flex-direction: column; }
        iframe { width: 100%; height: 100%; border: none; background-color: white; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>
            <img src="img/logo.png" alt="Logo"> Loja Celular
        </h2>
        <p>Menu de Navegação</p>
        
        <a href="listar_clientes.php" target="tela_principal">
            <img src="img/icone-cliente.png" alt="Icone Cliente"> Gestão de Clientes
        </a>
        <a href="#" target="tela_principal">
            <img src="img/icone-venda.png" alt="Icone Vendas"> Vendas e OS
        </a>
        <a href="listar_produtos.php" target="tela_principal">
            <img src="img/icone-estoque.png" alt="Icone Estoque"> Estoque de Produtos
        </a>
        <a href="listar_servicos.php" target="tela_principal">
            <img src="img/icone-servico.png" alt="Icone Serviço"> Catálogo de Serviços
        </a>
        
        <a href="logout.php" class="btn-logout" target="_top">🚪 Sair do Sistema</a>
    </div>

    <div class="content">
        <iframe name="tela_principal" src="listar_clientes.php"></iframe>
    </div>

</body>
</html>