<?php
// 1. Inicia a sessão para poder ler o crachá do usuário logado
session_start();
// Se não tiver perfil salvo, por segurança ele define como 'comum'
$perfil = $_SESSION['perfil'] ?? 'comum'; 

$host = 'localhost'; $dbname = 'loja_celular'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Lógica das Abas
    $aba_atual = $_GET['aba'] ?? 'todas';
    $filtro_sql = "";
    if ($aba_atual == 'pendentes') $filtro_sql = "WHERE v.status = 'Pendente'";
    if ($aba_atual == 'finalizadas') $filtro_sql = "WHERE v.status = 'Finalizado'";

    $sql = "SELECT v.id, v.tipo, v.quantidade, v.valor_total, v.data_registro, v.status,
                   c.nome AS nome_cliente, p.nome AS nome_produto, s.descricao AS desc_servico
            FROM vendas_os v
            LEFT JOIN clientes c ON v.cliente_id = c.id
            LEFT JOIN produtos p ON v.produto_id = p.id
            LEFT JOIN servicos s ON v.servico_id = s.id
            $filtro_sql
            ORDER BY v.data_registro DESC";
            
    $vendas = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { die("Erro: " . $e->getMessage()); }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Vendas e OS</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 30px; background-color: #f4f6f9; }
        h2 { color: #2c3e50; }
        .cabecalho-tabela { display: flex; justify-content: space-between; margin-bottom: 20px; align-items: center;}
        .btn-novo { padding: 10px 15px; background-color: #8e44ad; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; }
        
        /* Estilo das Abas */
        .abas { display: flex; gap: 10px; }
        .aba { padding: 8px 15px; background-color: #dfe6e9; color: #2d3436; text-decoration: none; border-radius: 4px; font-weight: bold; transition: 0.3s; }
        .aba:hover { background-color: #b2bec3; }
        .aba.ativa { background-color: #2c3e50; color: white; }

        table { width: 100%; border-collapse: collapse; background-color: white; border-radius: 5px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ecf0f1; font-size: 13px; }
        th { background-color: #2c3e50; color: white; }
        .badge { padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: bold; color: white; }
        .badge-venda { background-color: #3498db; } .badge-os { background-color: #e67e22; }
        .badge-pendente { background-color: #f1c40f; color: #333; } .badge-finalizado { background-color: #27ae60; }
        
        /* Botões de Ação */
        .acoes { display: flex; gap: 5px; }
        .btn-acao { padding: 5px 8px; text-decoration: none; border-radius: 3px; font-size: 11px; font-weight: bold; color: white; }
        .btn-imprimir { background-color: #34495e; }
        .btn-finalizar { background-color: #27ae60; }
        .btn-editar { background-color: #f39c12; }
        .btn-excluir { background-color: #e74c3c; }
    </style>
</head>
<body>
    <h2>🧾 Histórico de Vendas e OS</h2>
    
    <div class="cabecalho-tabela">
        <div class="abas">
            <a href="?aba=todas" class="aba <?= $aba_atual == 'todas' ? 'ativa' : '' ?>">📋 Todas</a>
            <a href="?aba=pendentes" class="aba <?= $aba_atual == 'pendentes' ? 'ativa' : '' ?>">⏳ Pendentes</a>
            <a href="?aba=finalizadas" class="aba <?= $aba_atual == 'finalizadas' ? 'ativa' : '' ?>">✅ Finalizadas</a>
        </div>
        <a href="cadastro_os.php" class="btn-novo">+ Novo Registro</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th> <th>Data</th> <th>Cliente</th> <th>Tipo</th> <th>Item</th> <th>Status</th> <th>Total</th> <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendas as $v): ?>
            <tr>
                <td><?= $v['id'] ?></td>
                <td><?= date('d/m/Y', strtotime($v['data_registro'])) ?></td>
                <td><b><?= htmlspecialchars($v['nome_cliente'] ?? 'Deletado') ?></b></td>
                <td>
                    <span class="badge <?= trim(strtolower($v['tipo'])) == 'venda' ? 'badge-venda' : 'badge-os' ?>">
                        <?= trim(strtolower($v['tipo'])) == 'venda' ? 'Venda' : 'OS' ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($v['nome_produto'] ?? $v['desc_servico'] ?? '-') ?></td>
                <td>
                    <span class="badge <?= $v['status'] == 'Finalizado' ? 'badge-finalizado' : 'badge-pendente' ?>">
                        <?= $v['status'] ?>
                    </span>
                </td>
                <td><b>R$ <?= number_format($v['valor_total'], 2, ',', '.') ?></b></td>
                <td class="acoes">
                    <a href="imprimir_os.php?id=<?= $v['id'] ?>" target="_blank" class="btn-acao btn-imprimir" title="Imprimir">🖨️</a>
                    
                    <?php if($v['status'] != 'Finalizado'): ?>
                        <a href="finalizar_os.php?id=<?= $v['id'] ?>" class="btn-acao btn-finalizar" title="Finalizar" onclick="return confirm('Marcar como finalizado?');">✅</a>
                    <?php endif; ?>
                    
                    <a href="editar_os.php?id=<?= $v['id'] ?>" class="btn-acao btn-editar" title="Editar">✏️</a>
                    
                    <?php if($perfil === 'admin'): ?>
                        <a href="excluir_os.php?id=<?= $v['id'] ?>" class="btn-acao btn-excluir" title="Excluir" onclick="return confirm('Excluir registro permanentemente?');">🗑️</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>