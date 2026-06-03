<?php
$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';

// Verifica se veio um ID pelo link
if(!isset($_GET['id'])) die("Nenhum registro selecionado para impressão.");

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Busca os dados da venda/OS e também os dados do cliente
    $sql = "SELECT v.*, c.nome AS cliente_nome, c.telefone, c.cpf, p.nome AS produto_nome, s.descricao AS servico_desc
            FROM vendas_os v
            LEFT JOIN clientes c ON v.cliente_id = c.id
            LEFT JOIN produtos p ON v.produto_id = p.id
            LEFT JOIN servicos s ON v.servico_id = s.id
            WHERE v.id = :id";
            
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_GET['id']]);
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$registro) die("Registro não encontrado no banco de dados.");

} catch (PDOException $e) { 
    die("Erro: " . $e->getMessage()); 
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Imprimir Recibo #<?= $registro['id'] ?></title>
    <style>
        /* Estilo de cupom térmico (preto e branco, fonte monoespaçada) */
        body { font-family: 'Courier New', Courier, monospace; margin: 20px; color: #000; background-color: #f4f4f4;}
        .recibo { background-color: white; max-width: 350px; margin: 0 auto; border: 1px dashed #000; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .cabecalho { text-align: center; border-bottom: 1px dashed #000; padding-bottom: 10px; margin-bottom: 10px; }
        .cabecalho h2 { margin: 0; font-size: 20px; text-transform: uppercase; }
        .cabecalho p { margin: 3px 0; font-size: 14px; }
        .linha { display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 14px; }
        .destaque { font-weight: bold; font-size: 16px; margin-top: 10px; border-top: 1px dashed #000; padding-top: 10px; }
        .rodape { text-align: center; margin-top: 30px; font-size: 12px; }
        
        /* Essa regra esconde o botão "Imprimir" quando o documento for para a impressora */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white; }
            .recibo { border: none; box-shadow: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align:center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; font-weight: bold; font-family: Arial;">🖨️ Imprimir Novamente</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer; font-family: Arial; margin-left: 10px;">Fechar Aba</button>
    </div>

    <div class="recibo">
        <div class="cabecalho">
            <h2>LOJA CELULAR</h2>
            <p><?= $registro['tipo'] == 'Venda' ? 'Comprovante de Venda' : 'Ordem de Serviço' ?></p>
            <p>Data: <?= date('d/m/Y H:i', strtotime($registro['data_registro'])) ?></p>
        </div>

        <div class="linha">
            <span>Nº Registro:</span> 
            <span>#<?= str_pad($registro['id'], 4, '0', STR_PAD_LEFT) ?></span>
        </div>
        
        <div class="linha">
            <span>Cliente:</span> 
            <span><?= htmlspecialchars($registro['cliente_nome']) ?></span>
        </div>
        
        <div class="linha">
            <span>Telefone:</span> 
            <span><?= htmlspecialchars($registro['telefone'] ?? 'Não informado') ?></span>
        </div>

        <div style="border-bottom: 1px dashed #000; margin: 15px 0;"></div>

        <div class="linha" style="font-weight: bold;">
            <span>Item / Descrição</span>
            <span>Qtd</span>
        </div>
        <div class="linha">
            <span><?= htmlspecialchars($registro['produto_nome'] ?? $registro['servico_desc'] ?? '-') ?></span>
            <span><?= $registro['quantidade'] ?></span>
        </div>

        <div class="linha destaque">
            <span>TOTAL:</span>
            <span>R$ <?= number_format($registro['valor_total'], 2, ',', '.') ?></span>
        </div>

        <div class="rodape">
            <p>Obrigado pela preferência!</p>
            <p>___________________________________<br>Assinatura do Cliente</p>
        </div>
    </div>

</body>
</html>